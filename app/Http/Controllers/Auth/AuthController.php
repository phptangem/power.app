<?php

namespace App\Http\Controllers\Auth;

use App\Services\ModelEdit;
use App\User;
use Validator,Auth,Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\Admin\Entity as Admin;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\Views
     */
    public function showLoginForm()
    {
        return view('power.admin.login');
    }
    public function login()
    {
        $service = new ModelEdit();
        Admin::$_RULES['username'] = str_replace('unique:admin','',Admin::$_RULES['username']);
        $credentials = $service->validation(Admin::class,Input::all(),['username', 'password']);
        if($credentials === false){
            return $service->prompt('验证失败');
        }
        if(Auth::attempt($credentials)){
            return prompt('登陆成功', 'success', Input::get('redirect', auth()->user()->index()));
        }else{
            return prompt('账号或密码错误', 'error');
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
