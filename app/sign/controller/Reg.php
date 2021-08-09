<?php
namespace app\sign\controller;
use think\facade\View;
use think\facade\Request;

use app\common\validate\User as vUser;
use app\common\model\User as mUser;

class Reg{
    use \liliuwei\think\Jump;
    public function index()
    {

        $login_status=config("app.sign.reg.status");

        if(!$login_status){
            return $this->error(config("app.sign.reg.msg"),'/');
        }

        if (Request::instance()->isPost()){

            if(input("post.pass/s",'')!=input("post.pass_2/s",'')){
                return $this->error('两次密码必须相同');
            }

            $data['user_user']=input("post.user/s",'');
            $data['user_pass']=input("post.pass/s",'');

            //验证
            $vUser = new vUser();
            $validateResult = $vUser->scene("login")->check($data);

            if(!$validateResult){
                return $this->error($vUser->getError());
            }

            $mUser=new mUser();

            //判断帐号是否存在
            $user_has=$mUser->hasUserName($data['user_user']);

            if($user_has){
                return $this->error('帐号已经存在');
            }
            
            $user_res=$mUser->reg($data);

            if(!$user_res){
                return $this->error('注册失败');
            }

            return $this->success('注册成功','/sign/login');

        }else{
            return view();
        }
    }
}
