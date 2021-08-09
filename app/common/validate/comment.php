<?php
namespace app\common\validate;

use think\Validate;

class Comment extends Validate
{
    protected $rule =   [
        'comment_post_id'  => 'max:10|min:1|number',
        'comment_reply_id'  => 'max:10|min:1|number',
        'comment_user_id'  => 'require|max:10|min:1|number',
        'comment_reply_user_id'   => 'require|max:20|min:1|alphaDash',
        'comment_content'=>'max:9999|min:2',
        'comment_img'=>'array',
        'comment_zan'=>'require|number',
        'comment_status'=>'require|number',
    ];
    
    protected $message  =   [

        'comment_post_id.max'     => '回复帖子失败',
        'comment_post_id.min'   => '回复帖子失败',
        'comment_post_id.number'   => '回复帖子失败',

        'comment_reply_id.max'     => '回复帖子失败',
        'comment_reply_id.min'   => '回复帖子失败',
        'comment_reply_id.number'   => '回复帖子失败',

        'comment_user_id.require' => '用户回复错误',
        'comment_user_id.max'     => '用户回复错误',
        'comment_user_id.min'   => '用户回复错误',
        'comment_user_id.number'   => '用户回复错误',

        'comment_reply_user_id.require' => '指定回复用户错误',
        'comment_reply_user_id.max'     => '指定回复用户错误',
        'comment_reply_user_id.min'   => '指定回复用户错误',
        'comment_reply_user_id.number'   => '指定回复用户错误',

        'comment_content.require' => '内容必须填写',
        'comment_content.max'     => '内容长度过多',
        'comment_content.min'   => '内容填写过少',

        'comment_img.array'   => '图片上传不正确',

        'comment_zan.require' => '系统错误：赞',
        'comment_zan.number'   => '系统错误：赞',

        'comment_status.require' => '系统错误：状态',
        'comment_status.number'   => '系统错误：状态',

    ];

    protected $scene = [
        'add'  =>  ['comment_post_id','comment_user_id','comment_reply_user_id','comment_content','comment_img','comment_zan','comment_status'],
    ]; 

}

?>