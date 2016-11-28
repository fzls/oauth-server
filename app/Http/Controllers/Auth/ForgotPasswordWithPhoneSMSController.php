<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ForgotPasswordWithPhoneSMSController extends Controller
{
    /**
     * 向用户展示通过手机验证码进行重置密码的表单
     */
    public function showResetByPhoneForm(){

    }

    /**
     * ajax，向用户手机发送验证码，并在password_resets中进行记录
     */
    public function sendSMSVerificationCode(){
        /*进行必要的验证工作*/

        /*通过手机号找到对应用户*/

        /*在password_resets表中删除所有该用户相关的记录*/

        /*生成一个随机的六位验证码*/

        /*将用户的邮箱，验证码，当前时间一并记录到password_resets中*/

        /*向用户手机发送验证码*/

        /*向web客户端发送状态的消息*/
    }
}
