<?php
namespace app\common\model;
use think\model as Models;
use think\model\concern\SoftDelete;

class Model extends Models
{
    use SoftDelete;
    //设置软删除的默认值
    public $defaultSoftDelete = 0;
    // 设置JSON数据返回数组
    public $jsonAssoc = true;
    //开启时间辍
    public $autoWriteTimestamp = true;
	 //隐藏字段
	public $hidden=[
		//用户
		'user_tel',
		'user_pass',
		'user_user',
		'user_end_login',
        'user_create_times',
        'user_update_times',
        'user_delete_times',
        'user_type',
		//帖子
		'post_type',
        'post_delete_times',
        //评论
		'comment_update_times',
        'comment_delete_times',
        //喜欢收藏
        'like_created_times',
        'like_update_times',
        'like_delete_times',
	];

    //时间统一获取器
    public function getTimes($value){
        
    }

}