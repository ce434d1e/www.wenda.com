<?php
namespace app\ask\controller;
use think\facade\View;
use app\common\model\Post as mPost;
use app\common\model\Comment as mComment;

class Index{
    public function index(){
        $mPost=new mPost();
        $lists=$mPost->alias('p')->where(['post_status' => 1])->join('user u', 'u.user_id = p.post_user_id and u.user_status=1')->limit(1)->select()->toArray();

        View::assign([
            'lists'  => $lists,
        ]);

        return view('ask@index/index');
    }

    public function unanswered(){
        $mPost=new mPost();
        $lists=$mPost->alias('p')->where(['post_status' => 0])->join('user u', 'u.user_id = p.post_user_id and u.user_status=1')->limit(1)->select()->toArray();

        View::assign([
            'lists'  => $lists,
        ]);

        return view('ask@index/index');
    }
}