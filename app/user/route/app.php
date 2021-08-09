<?php
use think\facade\Route;

Route::get('/',function(){
	return '';
});

// Route::rule('user/:id','user/index','GET');
Route::rule('test','Test/index','GET');