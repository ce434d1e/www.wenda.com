<?php
namespace app\common\model;
use app\common\model\Model;
use app\common\model\Post as mPost;
use think\facade\Db;

class User extends Model
{
	//表名称
	protected $name = 'user';
	//表的主键
	protected $pk = 'user_id';
	//自动写入创建时间辍
	protected $createTime = 'user_create_times';
	//自动写入更改时间辍
    protected $updateTime = 'user_update_times';
    //软删除
    protected $deleteTime = 'user_delete_times';
    //模型允许写入的字段列表（数组）
    protected $field = ['user_pass','user_delete_times','user_user','user_nickname','user_status','user_img','user_type'];
    //只读字段
    protected $readonly = ['user_user','user_create_times','user_id'];
	
	//查询一个帐号是否存在
	public function hasUserName($user_user){
		return $this->where(["user_user"=>$user_user])->count();
	}

    //查询一个昵称是否存在
    public function hasNickname($hasNickname){
        return $this->where(["user_nickname"=>$hasNickname])->count();
    }

	//注册一个用户
	public function reg($data){
        if(empty($data['user_nickname'])){
            $data['user_nickname']='昵称_'.substr(md5(rand(0,9999).time()),0,6);
        }
        
        $data['user_img']=rand(1,1000);
		$this->save($data);
		return $this->user_id;
	}

	//登录一个用户
	public function login($data){
		$data['user_pass']=$this->setUserPassAttr($data['user_pass'],$data);
		return $this->where(["user_user"=>$data['user_user'],'user_pass'=>$data['user_pass']])->limit(1)->select()->toArray();
	}

	//获取一个用户的基本信息
    public function getUser($user_id){
        return $this->cache('user_'.$user_id)->where(['user_id'=>$user_id])->limit(1)->select()->toArray();
    }

    //修改一个用户信息
    public function edit($where,$data){
    	return $this->cache('user_'.$where['user_id'])->where($where)->update($data);
    }

    //重新设置某个用户的赞的数量
    public function updateZanNumber($user_id){
        //获取评论的总数量
        $comment_count=$this->alias('u')
            ->join('comment c','c.comment_user_id=u.user_id and u.user_id='.$user_id)
            ->join('like l','l.like_action_id=c.comment_id and like_type="comment_zan"')
            ->count();
        //获取帖子总获得的总数量
        $post_count=$this->alias('u')
            ->join('post p','u.user_id='.$user_id.' and p.post_user_id=u.user_id')
            // ->join('like l','l.like_action_id=p.post_id and l.like_type="post_zan"')
            // ->fetchSql(true)
            ->count();
        $res=$comment_count+$post_count;
        $this->where(['user_id'=>$user_id])->save(['user_zan'=>$res]);
    }

    //从数据库中随机获取一个小号
    public function rand_user(){
        $user=$this->where(['user_type'=>'xiaohao'])->orderRand()->limit(1)->select()->toArray();
        if(!count($user)){
            return 5;
        }else{
            return $user[0]['user_id'];
        }
    }

    /*__======__修改器__======__*/

	//密码加密
	public function setUserPassAttr($value,$data=[])
    {
        $md5=md5($data['user_pass']);
        $md5=md5($md5.'__123__');
        $md5=md5($md5.'_'.$data['user_user']);
        $md5=md5($md5.'__987__');
        return $md5;
    }
}