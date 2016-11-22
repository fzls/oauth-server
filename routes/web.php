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

use App\User;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

/*re: 添加scopes定义*/
Route::get('/oauth/tokens/{token_id}', function (Request $request, $tokenId) {
    /*寻找id对应token信息*/
    $token = \Laravel\Passport\Token::query()->find($tokenId);
    /*若token存在，在对其进行检验，若检验通过，则将用户的数据添加上去*/
    if ($token && /*token 存在*/
        ! $token['revoked'] && /*token未被收回*/
        Carbon::now()->lt(new Carbon($token['expires_at'])) /*token未过期*/
    ) {
        $token['user'] = User::find($token['user_id']);
    }

    return $token;
});

Route::get('/test', function () {
    $test = "hello";
    echo $test;
});