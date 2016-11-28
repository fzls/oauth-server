<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /*RE: customize*/

    /**
     * Get the needed authorization credentials from the request.
     *
     * 在这里根据username的模式，判断使用username/phone/email中的一个用来登陆
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request) {
        $identifier = $request->get($this->username());
        $password = $request->get('password');

        $identifier_type = $this->getIdentifierType($identifier);

        return [
            $identifier_type => $identifier,
            'password' =>$password,
        ];
    }

        /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        /*TODO*/
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'identifier';
    }

    /**
     * 根据identifier的特征，确认它是username/email/phone中的哪一种
     *
     * @param $identifier
     *
     * @return string
     */
    public function getIdentifierType($identifier){
        /*检测是否是邮箱*/
        if(filter_var($identifier, FILTER_VALIDATE_EMAIL)){
            return 'email';
        }

        /*检测是否是手机号码（大陆）*/
        if($this->isPhone($identifier)){
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
    public function isPhone($phone){
        $phone_regex = '/^1[34578]\d{9}$/';

        return preg_match($phone_regex, $phone);
    }
}
