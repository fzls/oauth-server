<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

/*re: 添加scopes定义*/
Route::get('/oauth/tokens/{token_id}',function (Request $request, $tokenId){
    return \Laravel\Passport\Token::query()->find($tokenId);
});

Route::get('/test',function (){
    $test="hello";
    echo $test;
});