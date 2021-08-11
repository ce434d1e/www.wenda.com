<?php
use think\facade\Route;

Route::get('/',"\app\ask\controller\index@index")->ext("html");
// Route::get('test',"test/index");