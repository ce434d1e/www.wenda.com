<?php
use think\facade\Route;

Route::get('/',"\app\ask\controller\Index@index")->ext("html");
Route::get('//',"\app\ask\controller\Index@index")->ext("html");
// Route::get('test',"test/index");