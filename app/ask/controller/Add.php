<?php
namespace app\ask\controller;
use think\facade\View;
use think\facade\Request;
use app\common\model\User as mUser;
use app\common\validate\Post as vPost;
use app\common\model\Post as mPost;
use app\common\model\Comment as mComment;

class Add{
    protected $middleware = [
        \app\common\middleware\Login::class,
    ];

    use \liliuwei\think\Jump;
    public function post(){
        if (Request::instance()->isPost()){
            $data['post_user_id'] = $_SERVER['user_id'];
            $data['post_type_id'] = 0;
            $data['post_title'] = input("post.title", '');
            $data['post_body'] = input("post.text", '');
            $data['post_img'] = input("post.img_list", []);
            $data['post_issue'] = input("post.issue/d", '');
            $data['post_video'] = input("post.video/s", '');
            $data['post_view'] = 0;
            $data['post_comment'] = 0;
            $data['post_zan'] = 0;
            $data['post_status'] = 0;

            //向数据库中随机获取小号ID
            $mUser = new mUser();
            $rand_user_vest = $mUser->rand_user();
            $data['post_user_id'] = $rand_user_vest;

            $vPost = new vPost();
            $validateResult = $vPost->scene("add")->check($data);

            if (!$validateResult) {
                $json['msg'] = $vPost->getError();
                return echojson($json);
            }

            $mPost = new mPost();
            $res = $mPost->insert($data);

            if ($res) {
                return $this->error('发布成功',"/ask/{$res}.html");
            }else{
                return $this->error('发布失败');
            }
        }else{
            View::layout(true);
            return view();
        }
    }

    public function comment(){
        $data['comment_post_id']=input("post.comment_post_id/d");
        $data['comment_content']=input("post.comment_body/s");
        $data['comment_status']=1;

        $mUser = new mUser();
        $rand_user_vest = $mUser->rand_user();
        $data['comment_user_id'] = $rand_user_vest;

        $mComment=new mComment();
        $comment_res=$mComment->insert($data);

        var_dump($comment_res);

    }
}