<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 根据identifier的特征，确认它是username/email/phone中的哪一种
     *
     * @param $identifier
     *
     * @return string
     */
    public function getIdentifierType($identifier) {
        /*检测是否是邮箱*/
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        /*检测是否是手机号码（大陆）*/
        if ($this->isPhone($identifier)) {
            return 'phone';
        }

        /*若前者均不符合，则认为是用户名*/

        return 'username';
    }

    /**
     * 确认手机号码是否有效，若有效的返回 1，否则 0
     *
     * @param $phone
     *
     * @return int
     */
    public function isPhone($phone) {
        $phone_regex = '/^1[34578]\d{9}$/';

        return preg_match($phone_regex, $phone);
    }
}
