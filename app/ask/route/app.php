<?php
use think\facade\Route;

Route::pattern([
    'name'  =>  '\w+',
    'id'    =>  '\d+',
]);

Route::get('/',"index");
Route::get('<id>',"post/index");
Route::get('unanswered',"index/unanswered");


Route::rule('/add',"add/post","GET|POST");
Route::post('add/comment',"add/comment");