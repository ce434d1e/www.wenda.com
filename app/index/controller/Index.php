<?php
namespace app\index\controller;
use think\facade\View;

class Index{
    use \liliuwei\think\Jump;
    public function index(){
        return View::fetch("ask@/index/index");
    }
}