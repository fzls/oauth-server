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
/*手机验证码进行重置密码*/
Route::post('/password/phone', 'Auth\ForgotPasswordWithPhoneSMSController@sendSMSVerificationCode');

Route::get('/home', 'HomeController@index');

/*re: 添加scopes定义*/
Route::get('/oauth/tokens/{token_id}', 'TokenInfoController@token_info');


Route::get('/test/{uid}', 'TokenInfoController@permissions');

Route::get('/test', function (\Illuminate\Http\Request $request) {
    $title   = $request->input('title');
    $content = $request->input('content');

    Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message) {

        $message->from('me@gmail.com', 'Christian Nwamba');

        $message->to('fzls.zju@gmail.com');

    });

    return response()->json(['message' => 'Request completed']);
});