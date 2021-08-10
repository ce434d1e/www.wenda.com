<?php
use think\facade\Route;

Route::get('/',"\app\ask\controller\index@index");
Route::get('test',"test/index");