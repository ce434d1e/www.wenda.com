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

        $_SERVER['isSearchEngine']=isSearchEngine();

        if($_SERVER['isSearchEngine']){
            //设置coooke给用户浏览器
            cookie("ise",1,86400*15);
        }else{
            //判断当前是否是ise用户
            $ise=cookie("ise");
            if($ise=="1"){
                $_SERVER['isSearchEngine']=true;
            }
        }

        return $next($request);
    }
}
