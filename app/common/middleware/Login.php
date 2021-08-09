<?php
declare (strict_types = 1);

namespace app\common\middleware;

class Login{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    use \liliuwei\think\Jump;
    public function handle($request, \Closure $next){
        if(!$_SERVER['user_id']){
            header("location:/sign/login");
            exit;
            return $this->error('需要登录','/sign/login');
        }

        return $next($request);
    }
}
