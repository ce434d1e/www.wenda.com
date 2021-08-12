<?php
use think\facade\Route;

Route::get('/',"index/index");

Route::get('tags',"tags/index");
Route::rule('tags/add',"tags/add","GET|POST");
Route::rule('tags/<id>',"tags/edit","GET|POST");

Route::get('keys',"keys/index");
Route::get('keys/inits',"keys/inits");
Route::get('keys/lists',"keys/lists");
Route::rule('keys/prohibit',"keys/prohibit","GET|POST");
Route::rule('keys/allow',"keys/allow",'GET|POST');
Route::rule('keys/del',"keys/del",'GET|POST');


Route::rule('keys/<id>',"keys/id",'GET|POST');