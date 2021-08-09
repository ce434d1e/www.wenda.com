<?php
namespace app\common\model;
use app\common\model\Model;
use app\common\model\Post as mPost;
use app\common\model\User as mUser;
use app\common\model\Comment as mComment;
use app\common\model\Like as mLike;


class Like extends Model
{
	//表名称
	protected $name = 'like';
	//表的主键
	protected $pk = 'like_id';
    //自动写入创建时间辍
	protected $createTime = 'like_created_times';
	//自动写入更改时间辍
    protected $updateTime = 'like_update_times';
    //软删除
    protected $deleteTime = 'like_delete_times';

    /*
	类型：
		post_zan	帖子点赞
		post_like	帖子收藏
		comment_zan 	评论点赞
		user_like	关注用户
    */
	protected $type_list=[
		'post_zan'=>[
			'name'=>'帖子点赞',
			'close'=>'取消点赞',
			'success'=>'点赞成功',
			'event'=>true,
		],
		'post_like'=>[
			'name'=>'帖子收藏',
			'close'=>'取消收藏',
			'success'=>'收藏成功',
			'event'=>false,
		],
		'comment_zan'=>[
			'name'=>'评论点赞',
			'close'=>'取消点赞',
			'success'=>'点赞成功',
			'event'=>true,
		],
		'user_like'=>[
			'name'=>'关注用户',
			'close'=>'取消关注',
			'success'=>'关注成功',
			'event'=>true,
		],
	];


	public function post($post_id){
		$where['like_action_id']=$post_id;
		$where['like_type']='post';
		$where['like_user_id']=$GLOBALS['user_id'];
		$res_count=$this->where($where)->count();
		if($res_count){
			//判断是否是软删除
			$this->where($where)->find()->force()->delete();
			$json['res']=0;
			$json['msg']='取消点赞';
		}else{
			$this->save($where);
			$json['res']=1;
			$json['msg']='点赞成功';
		}
		return $json;
	}
	//判断某个帖子某个用户是否有点赞
	//@action_id 	被执行的ID  如执行帖子ID
	//@type 		类型
	public function is($action_id,$type){
		$where['like_action_id']=$action_id;
		$where['like_type']=$type;
		$where['like_user_id']=$GLOBALS['user_id'];
		return !!$this->where($where)->find();
	}
	//用户行为切换
	//用户点赞之后 再执行则是取消.
	//@action_id 	被执行的ID  如执行帖子ID
	//@type 		类型
	public function toggle($action_id,$type){

		if(empty($this->type_list[$type])){
			'ACTION=>like:toggle 类型不存在';
			exit;
		}else{
			$type_list=$this->type_list[$type];
		}

		$where['like_action_id']=$action_id;
		$where['like_type']=$type;
		$where['like_user_id']=$GLOBALS['user_id'];
		$res_count=$this->where($where)->count();

		if($res_count){
			$res=$this->where($where)->find()->force()->delete(true);
			$json['res']=0;
			$json['msg']=$type_list['close'];
		}else{
			$this->save($where);
			$json['res']=1;
			$json['msg']=$type_list['success'];
		}

		//重新设置当前点先赞数量
		$json['count']=$this->where(['like_type'=>$type,'like_action_id'=>$action_id])->count();

		//执行相关操作
		if($type_list['event']){
			$fn='event_'.$type;
			$object['action_id']=$action_id;
			$object['type']=$type;
			$object['user_id']=$GLOBALS['user_id'];
			$this->$fn($object);
		}
		return $json;
	}

	//为评论重新设置点赞次数
	//从link表中计算前某个用户的点赞次数
	public function event_comment_zan($object){

		//获取到该评论的发布人
		$mComment=new mComment();
		$comment=$mComment->find($object['action_id']);

		$mLike=new mLike();
		$where['like_type']=$object['type'];
		$where['like_action_id']=$object['action_id'];
		// $where['like_user_id']=$comment->comment_user_id;
		$count=$mLike->where($where)->count();

		//修改当前评论的总赞数
		$mComment->edit($object['action_id'],['comment_zan'=>$count]);

		$mPost=new mPost();
		$post=$mPost->find($comment->comment_post_id);
		$object['user_id']=$comment->comment_user_id;
		// //重置用户赞数
		event("user_zan",$object);
	}

	//为帖子的点赞重新计算
	public function event_post_zan($object){
		$where['like_type']=$object['type'];
		$where['like_action_id']=$object['action_id'];
		$where['like_user_id']=$object['user_id'];
		$json['count']=$this->where($where)->count();
		//为评论重新设置点赞次数
		$mPost=new mPost();
		$post=$mPost->find($object['action_id']);
		$mPost->edit(['post_id'=>$object['action_id']],['post_zan'=>$json['count']]);
		//重置用户赞数
		$object['user_id']=$post->post_user_id;
		event("user_zan",$object);
	}

	//用户关注
	public function event_user_like($object){
		//当前操作人的关注数量修改
		$where_1['like_type']=$object['type'];
		$where_1['like_user_id']=$object['user_id'];
		$mLike_1=new mLike();
		$count_1=$mLike_1->where($where_1)->count();
		$mUser_1=new mUser();
		$mUser_1->where(['user_id'=>$object['user_id']])->save(['user_attention'=>$count_1]);
		//当前被操作人的粉丝数量修改
		$where_2['like_type']=$object['type'];
		$where_2['like_action_id']=$object['action_id'];
		$mLike_2=new mLike();
		$count_2=$mLike_2->where($where_2)->count();

		$mUser_2=new mUser();
		$mUser_2->where(['user_id'=>$object['action_id']])->save(['user_fan'=>$count_2]);
	}

	//事件
	public static function onAfterWrite($object) {
        
    }

}