<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

class TokenInfoController extends Controller {
    public function token_info($tokenId) {
        /*寻找id对应token信息*/
        $token = Token::query()->find($tokenId);
        /*若token存在，在对其进行检验，若检验通过，则将用户的数据添加上去*/
        if ($token && /*token 存在*/
            ! $token['revoked'] && /*token未被收回*/
            Carbon::now()->lt(new Carbon($token['expires_at'])) /*token未过期*/
        ) {
            $token['user'] = User::find($token['user_id']);

            /*添加permissions字段*/
            $token['permissions'] = $this->permissions($token['user_id']);
        }

        return $token;
    }

    /**
     * @param $uid
     *
     * @return \Illuminate\Support\Collection
     */
    public function permissions($uid) {

        $user        = User::with('roles.permissions')->find($uid);
        $permissions = [];
        foreach ($user->roles as $role) {
            $permissions = array_merge($permissions, $role->permissions->toArray());
        }

        return collect($permissions)->unique();
    }
}
