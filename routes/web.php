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
Route::get('/oauth/tokens/{token_id}', 'TokenInfoController@token_info');

Route::get('/test', function () {
    $user = User::with('roles.permissions')->find(1);
    $permissions = [];
    foreach ($user->roles as $role) {
        $permissions = array_merge($permissions, $role->permissions->toArray());
    }
    return response()->json(collect($permissions)->unique());
});