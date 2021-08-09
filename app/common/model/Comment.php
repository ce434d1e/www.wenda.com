<?php
namespace app\common\model;
use app\common\model\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{
	use SoftDelete;
	//表名称
	protected $name = 'comment';
	//表的主键
	protected $pk = 'comment_id';
	//模型允许写入的字段列表（数组）
	protected $field = [];
    //设置输出字段类型
    protected $type = [
        'comment_img' =>  'json',
    ];
    //自动写入创建时间辍
	protected $createTime = 'comment_create_times';
	//自动写入更改时间辍
    protected $updateTime = 'comment_update_times';
    //软删除
    protected $deleteTime = 'comment_delete_times';
    /*
	comment_is_zan 	当前评论是否被当前用户点赞
    */

	//写入一个评论
	public function insert($data){
		$this->save($data);
		return $this->comment_id;
	}

	//单独获取一个帖子评论
	public function getPostComment($comment_post_id){
		return $this->alias('c')->where(['comment_post_id'=>$comment_post_id,'comment_status'=>1])->join('user u','c.comment_user_id=u.user_id and u.user_status=1')->order("comment_zan desc")->limit(1)->select()->toArray();
	}

	//获取一个帖子的评论例表
	public function getCommentList($where,$option=[]){
		$where['comment_status']=1;
		$where['comment_reply_id']=0;

		$select_sql='';
		if(!empty($_SERVER['user_id'])){
			$select_sql=",(SELECT count(*) FROM `like` WHERE like_user_id = ".$_SERVER['user_id']." AND like_type = 'comment_zan' AND like_action_id = c.comment_id and user_status=1) as comment_is_zan";
		}
		$res=$this->alias('c')
			->where($where)
			->join('user u','c.comment_user_id=u.user_id and u.user_status=1')
			->page($option['pages'],config("app.limit"))
			->field('c.*,u.*'.$select_sql)
			->order("c.comment_zan desc")
			// ->fetchSql(true)
			->select()
			->toArray();

		foreach ($res as $key => $value) {
			$r=$this->getCommentChild($value['comment_id'],['limit'=>3]);
			$res[$key]['list']=$r;
		}

		return $res;
	}

	//获取一个帖子的评论例表
	public function getCommentChildList($where,$option=[]){
		$where['comment_status']=1;

		$select_sql='';
		if(!empty($_SERVER['user_id'])){
			$select_sql=",(SELECT count(*) FROM `like` WHERE like_user_id = ".$_SERVER['user_id']." AND like_type = 'comment_zan' AND like_action_id = c.comment_id and user_status=1) as comment_is_zan";
		}
		$res=$this->alias('c')
			->where($where)
			->join('user u','c.comment_user_id=u.user_id and u.user_status=1')
			->page($option['pages'],config("app.limit"))
			->field('c.*,u.*'.$select_sql)
			->order("c.comment_zan desc")
			// ->fetchSql(true)
			->select()
			->toArray();

		foreach ($res as $key => $value) {
			$r=$this->getCommentChild($value['comment_id'],['limit'=>3]);
			$res[$key]['list']=$r;
		}

		return $res;
	}

	//根据评论ID返回数据 并返回用户信息
	public function getComment($comment_id,$comment_status=1){
		$select_sql='';
		if(!empty($_SERVER['user_id'])){
			$select_sql=",(SELECT count(*) FROM `like` WHERE like_user_id = ".$_SERVER['user_id']." AND like_type = 'comment_zan' AND like_action_id = c.comment_id and user_status=1) as comment_is_zan";
		}
		return $this->alias('c')
			->where(['comment_id'=>$comment_id,'comment_status'=>$comment_status])
			->join('user u','c.comment_user_id=u.user_id and u.user_status=1')
			->limit(1)
			->field('*'.$select_sql)
			->order("comment_zan desc")
			->select()
			->toArray();
	}

	//根据评论ID返回数据 不包含其它
	public function getCommentData($comment_id){
		return $this->where(['comment_id'=>$comment_id])->limit(1)->select()->toArray();
	}

	//获取评论的子例表 用于例表显示
	public function getCommentChild($comment_id,$option=['limit'=>1]){
		$select_sql='';
		if(!empty($_SERVER['user_id'])){
			$select_sql=",(SELECT count(*) FROM `like` WHERE like_user_id = ".$_SERVER['user_id']." AND like_type = 'comment_zan' AND like_action_id = c.comment_id and user_status=1) as commment_is_zan";
		}
		$r_sql=$this->alias('c')
			->where(['comment_reply_id'=>$comment_id,'comment_status'=>1])
			->join('user u','c.comment_user_id=u.user_id and u.user_status=1')
			->limit($option['limit'])
			->field('*'.$select_sql);
		$r_data['count']=$r_sql->count();
		$r_data['list']=$r_sql->select()->toArray();
		return $r_data;
	}

	//帖子评论即增加帖子评论数
	public static function onAfterInsert($object)
    {
    	//获取到原帖子的发帖人
    	$Comment=new Comment();
    	if($object->comment_post_id){
    		$Comment->updataPostCommentNumber($object->comment_post_id);
    	}
    	if($object->comment_reply_id){
    		$comment2=new Comment();
    		$comment=$comment2->find($object->comment_reply_id);
    		$post_id=$comment->comment_post_id;
    		if($post_id){
    			$c3=new Comment();
    			$c3_res=$c3->find($object->comment_id);
    			$c3_res->comment_post_id=$post_id;
    			$res=$c3_res->save();
    			if($res){
    				//这里需要后台审核  所以暂时不使用
    				// $Comment->updataPostCommentNumber($post_id);
    			}
    		}
    	}
    }
    //更新帖子的总评论数
    public function updataPostCommentNumber($post_id){
    	$where['comment_post_id']=$post_id;
    	$where['comment_status']=1;
    	$count=$this->where($where)->count();

    	$Post = new Post();
    	return $Post->where(['post_id'=>$post_id])->update(['post_comment'=>$count]);
    }

    //更新某个评论的赞数 以及评论人的总赞数
    public function updataCommentZanNumber($comment_id){
    	$where['comment_reply_id']=$comment_id;
    	$where['comment_status']=1;
    	$count=$this->where($where)->count();
    	$comment=$this->find($comment_id);
    	//为当前发布评论的用户重置赞数
    }
    
    //修改评论
    public function edit($comment_id,$data){
    	return $this->where(['comment_id'=>$comment_id])->save($data);
    }

    //删除评论
    public function deletes($comment_id){
    	return $this->find($comment_id)->delete();
    }

}