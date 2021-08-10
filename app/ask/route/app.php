<?php
use think\facade\Route;

Route::get('/',"index");
Route::rule('/add',"add/post","GET|POST");
Route::get('<id>',"post/index");
Route::post('add/comment',"add/comment");
Route::post('unanswered',function(){
	return 3;
});