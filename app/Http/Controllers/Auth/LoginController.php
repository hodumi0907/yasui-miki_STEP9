<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
    protected $redirectTo = '/index'; //リダイレクト先の設定（初期値：/home）

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this -> middleware('guest') -> except('logout');
        $this -> middleware('auth') -> only('logout');
    }

    /**
     * ログイン時のバリデーションをカスタマイズ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request -> validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ]);
    }

    /**
     * ログイン失敗時のエラーメッセージをカスタマイズ
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['メールアドレスまたはパスワードが正しくありません。'],
        ]);
    }
}
