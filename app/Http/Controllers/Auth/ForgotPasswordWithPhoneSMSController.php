<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpseclib\Crypt\Random;

class ForgotPasswordWithPhoneSMSController extends Controller
{
    /**
     * ajax，向用户手机发送验证码，并在password_resets中进行记录
     */
    public function sendSMSVerificationCode(Request $request){
        /*进行必要的验证工作*/
        $this->validate(
            $request,
            [
                'phone'=>'required|regex:/1[34578]\d{9}/'
            ]
        );

        /*通过手机号找到对应用户*/
        $phone = $request->get('phone');
        $user = User::wherePhone($phone)->first();

        /*在password_resets表中删除所有该用户相关的记录*/
        \DB::table('password_resets')->where('email', $user->email)->delete();

        /*生成一个随机的六位验证码*/
        $code = sprintf('%06d', random_int(0, 999999));

        /*将用户的邮箱，验证码，当前时间一并记录到password_resets中*/
        \DB::table('password_resets')->insert(
            [
                'email'=> $user->email,
                'token'=>$code,
                'created_at'=> new Carbon()
            ]
        );

        /*向用户手机发送验证码*/
        /*RE:不准备投入经费，遂弃用*/

        /*向web客户端发送状态的消息*/
        return "meow，人家没钱发短信呀TAT 要不换成使用email进行重置？";
    }
}
