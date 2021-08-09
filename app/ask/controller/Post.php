<?php
namespace app\ask\controller;
use think\facade\View;
use app\common\model\Post as mPost;

class Post{
    public function index($id){
        $id=(int)$id;

        $mPost=new mPost();
        $post=$mPost->where(['post_id'=>$id])->limit(1)->select()->toArray();
        if(!count($post)){
            return view('../app/common/view/404.php');
        }
        $post=$post[0];

        //标签处理
        $tags=array_filter(explode(",",$post['post_tags']));
        $post['post_tags_list']=$tags;

        //获取评论

        View::assign([
            'post'  => $post,
        ]);

        return view();
    }
}