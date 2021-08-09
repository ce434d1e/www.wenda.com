<?php
declare (strict_types = 1);

namespace app\common\middleware;

class Auth{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //判断用户是否已经登录
        $_SERVER['user_id']=0;
        $_SERVER['user']=[];
        $user_token=cookie("user_token");
        if($user_token){
            $user_res=cache("user_token_".$user_token);
            if($user_res){
                $_SERVER['user_id']=$user_res['user_id'];
                $_SERVER['user']=$user_res;
            }
        }

        return $next($request);
    }
}
