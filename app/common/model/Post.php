<?php
namespace app\common\model;

use app\common\model\Model;
use think\model\concern\SoftDelete;
use app\common\model\Type as mType;
use app\common\model\Lottery as mLottery;

class Post extends Model
{
	use SoftDelete;
	//表名称
	protected $name = 'post';
	//表的主键
	protected $pk = 'post_id';
	//模型允许写入的字段列表（数组）
	protected $field = [];
	//设置输出字段类型
	protected $type = [
		'post_img' =>  'json',
	];

	//自动写入创建时间辍
	protected $createTime = 'post_create_times';
	//自动写入更改时间辍
	protected $updateTime = 'post_update_times';
	//软删除
	protected $deleteTime = 'post_delete_times';

	//写入一个文章
	public function insert($data){
		$this->save($data);
		return $this->post_id;
	}

	//修改一个帖子
	public function edit($where, $data){
		return $this->update($data, $where);
	}

	//获取一个例表
	public function lists($option = [])
	{
		//字符分类
		if ((int)$option['type'] == 0) {
			$mType = new mType();
			$type_res = $mType->where(['type_url' => $option['type']])->find();
			if (!$type_res) {
				return [];
			}

			$type_id = $type_res->type_id;
			$mType_list = new mType();
			$type_list = $mType_list->where(['type_top_id' => $type_id])->field('type_id')->select()->map(function ($value) {
				return $value['type_id'];
			})->toArray();

			if (count($type_list)) {
				$model = $this->alias('p')->whereIn('post_type_id', $type_list)->join('user u', 'u.user_id = p.post_user_id and u.user_status=1 and p.post_status=1');
			} else {
				$model = $this->alias('p')->where(['post_type_id' => $type_id])->join('user u', 'u.user_id = p.post_user_id and u.user_status=1 and p.post_status=1');
			}
		} else {
			$w['post_type_id'] = (int)$option['type'];
			$model = $this->alias('p')->where($w)->join('user u', 'u.user_id = p.post_user_id and u.user_status=1 and p.post_status=1');
		}

		if ($option['is_count']) {
			$model_count = $model;
			$list['count'] = $model_count->count();
			$list['list'] = $model->limit(($option['pages'] - 1) * $option['limit'], $option['limit'])->order("post_create_times desc")->select()->toArray();
			return $list;
		}
		return $model->limit($option['limit'])->order("post_create_times desc")->page($option['pages'])->withAttr('post_body', function ($value, $data) {
			$html = htmlspecialchars_decode(htmlspecialchars_decode($value));
			$html= preg_replace("/<(.*?)>/","",$html);
			$html = str_replace("\n", '', $html);
			$html = str_replace("\r", '', $html);
			$html_2 = mb_substr($html, 0, 70, "utf-8");
			if ($html != $html_2) {
				$html_2 .= '...';
			}
			return $html_2;
		})->select()->toArray();
	}

	//删除一个帖子
	public function delete_post($where){
		$post = $this->where($where)->find();
		if (!$post) {
			return false;
		}
		return $post->delete();
	}

}
