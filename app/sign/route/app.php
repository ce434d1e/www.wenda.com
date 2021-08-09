<?php
use think\facade\Route;

Route::get('/',function(){
	return '';
});

Route::rule('login','login/index','GET|POST');
Route::rule('reg','reg/index','GET|POST');