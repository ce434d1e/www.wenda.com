<?php
namespace app\sign\controller;
use think\facade\View;
use think\facade\Request;

use app\common\validate\User as vUser;
use app\common\model\User as mUser;

class Login{
    use \liliuwei\think\Jump;
    public function index(){
        $login_status=config("app.sign.login.status");

        if(!$login_status){
            return $this->error(config("app.sign.login.msg"),'/');
        }

        if (Request::instance()->isPost()){
            $data['user_user']=input("post.user/s",'');
            $data['user_pass']=input("post.pass/s",'');

            //验证
            $vUser = new vUser();
            $validateResult = $vUser->scene("login")->check($data);

            if(!$validateResult){
                return $this->error($vUser->getError());
            }

            $mUser=new mUser();
            $user_res=$mUser->login($data);

            if(!count($user_res)){
                return $this->error('帐号密码错误');
            }
            $user_res=$user_res[0];

            $token=md5($user_res['user_id'].time());

            cookie("user_token",$token,15*86400);
            cache('user_token_'.$token,$user_res,15*86400);

            return $this->success('登录成功','/');

        }else{
            return view();
        }
    }
}
