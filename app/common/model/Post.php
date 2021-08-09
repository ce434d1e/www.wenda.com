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

	//删除一个帖子
	public function delete_post($where){
		$post = $this->where($where)->find();
		if (!$post) {
			return false;
		}
		return $post->delete();
	}

}
