<?php
namespace app\common\validate;

use think\Validate;

class Post extends Validate
{
    protected $rule =   [
        'post_id'  => 'require|max:10|min:1|number',
        'post_user_id'  => 'require|max:10|min:1|number',
        'post_type'   => 'require|max:20|min:1|alphaDash',
        'post_type_id'   => 'require|max:20|min:1|alphaDash',
        'post_title'=>'max:255|min:2',
        'post_body'=>'max:65555|min:0',
        'post_img'=>'array',
        'post_view'=>'require|number',
        'post_comment'=>'require|number',
        'post_zan'=>'require|number',
        'post_status'=>'require|number',
    ];
    
    protected $message  =   [

        'post_id.require' => '帖子ID不存在',
        'post_id.max'     => '帖子ID不存在',
        'post_id.min'   => '帖子ID不存在',
        'post_id.number'   => '帖子ID不存在',

        'post_user_id.require' => '当前登录帐号不正确',
        'post_user_id.max'     => '当前登录帐号不正确',
        'post_user_id.min'   => '当前登录帐号不正确',
        'post_user_id.number'   => '当前登录帐号不正确',

        'post_type.require' => '当前分类不正确',
        'post_type.max'     => '当前分类不正确',
        'post_type.min'   => '当前分类不正确',
        'post_type.number'   => '当前分类不正确',

        'post_type_id.require' => '当前发布的分类不正确',
        'post_type_id.max'     => '当前发布的分类不正确',
        'post_type_id.min'   => '当前发布的分类不正确',
        'post_type_id.number'   => '当前发布的分类不正确',

        'post_title.require' => '标题必须填写',
        'post_title.max'     => '标题最小长度为：255个字符',
        'post_title.min'   => '标题最小长度为：10个字符',
        'post_title.number'   => '标题格式必须是：汉字、字母、数字，下划线_及破折号',

        'post_body.require' => '内容必须填写',
        'post_body.max'     => '内容长度过多',
        'post_body.min'   => '内容填写过少',

        'post_img.array'   => '图片上传不正确',

        'post_view.require' => '系统错误：浏览次数',
        'post_view.number'   => '系统错误：浏览次数',

        'post_comment.require' => '系统错误：评论次数',
        'post_comment.number'   => '系统错误：评论次数',

        'post_zan.require' => '系统错误：赞数',
        'post_zan.number'   => '系统错误：赞数',

        'post_status.require' => '系统错误：状态',
        'post_status.number'   => '系统错误：状态',

    ];

    protected $scene = [
        'add'  =>  ['post_user_id','post_type_id','post_title','post_body','post_img','post_view','post_comment','post_zan','post_status'],
        'edit'=>['post_title','post_body','post_img','post_status'],
    ]; 

}

?>