<?php
use think\facade\Route;

Route::pattern([
    'name'  =>  '\w+',
    'id'    =>  '\d+',
]);

// Route::get('/',"index")->ext("html");
Route::get('<id>',"post/index")->ext("html");
Route::get('unanswered',"index/unanswered")->ext("html");
Route::get('tags/<id>',"tags/index")->ext("html");
Route::get('rand',"index/postRan")->ext("html");

Route::rule('/add',"add/post","GET|POST")->ext("html");
Route::post('add/comment',"add/comment")->ext("html");