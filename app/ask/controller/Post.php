<?php
namespace app\ask\controller;
use think\facade\View;
use app\common\model\Post as mPost;
use app\common\model\Comment as mComment;
use app\ask\controller\Right as cRight;

class Post{
    public function index($id){
        $id=(int)$id;

        $mPost=new mPost();
        $post=$mPost->where(['post_id'=>$id])->limit(1)->select()->toArray();
        if(!count($post)){
            return view('../app/common/view/404.php');
        }
        $post=$post[0];

        //获取评论
        $mComment=new mComment();
        $comment_list=$mComment->getCommentChildList(['comment_post_id'=>$id],['pages'=>1]);

        //标签处理
        $cRight=new cRight();
        $post_tags_list=$cRight->postRelated($post['post_tags']);

        //增加一个浏览量
        $mPost->where(['post_id'=>$id])->inc('post_view')->update();

        View::assign([
            'post'  => $post,
            'comment_list'=>$comment_list,
            'post_tags_list'=>$post_tags_list,
            'title'=>$post['post_title'],
            'keywords'=>implode(",",array_column($post['post_tags']['list'],'tags_name')),
        ]);

        return view();
    }
}