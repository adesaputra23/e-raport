<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoleUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function ShowLogin()
    {
        $url_prefix = str_replace('/','',Request()->route()->getPrefix());
        if ($url_prefix == "admin") {
            return view('admin/login_admin');
        }
        return view('login');
    }

    public function ProsesLogin(Request $request)
    {
        $is_email = $request->email;
        $fieldType = filter_var($is_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_code';
        $is_user = [
            $fieldType => $request->email,
            'password' => $request->password,
        ];
        $url_prefix = str_replace('/','',Request()->route()->getPrefix());
        if ($url_prefix == 'admin') {
            $cek_role = RoleUser::where('user_code', $is_user['user_code'])->where('user_role', 1)->first();
            if ($cek_role == null) {
                return redirect()->back()->withInput($request->only('email', 'password'))->with('error', 'Anda tidak punya akses sebagai Admin.!');
            }else{
                if (Auth::attempt($is_user, false)) {
                    $request->session()->put(User::SES_PREFIX, $url_prefix);
                    return redirect()->intended(route('home.admin'));
                }
            }
        }else{
            $cek_role_user = RoleUser::where('user_code', $is_user['user_code'])->where('user_role', '!=', 1)->first();
            if ($cek_role_user == null) {
                return redirect()->back()->withInput($request->only('email', 'password'))->with('error', 'Role user anda belum di seting.!');
            }else{
                if (Auth::attempt($is_user, false)) {
                    $request->session()->put(User::SES_PREFIX, $url_prefix);
                    return redirect()->intended(route('home'));
                }
            }
        }
        return redirect()->back()->withInput($request->only('email', 'password'))->with('error', 'NIK/NISN/Email yang anda masukan salah.!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $url_prefix = str_replace('/','',Request()->route()->getPrefix());
        $request->session()->forget('prefix');
        if ($url_prefix == 'admin') {
            return redirect()->route('login.admin');
        }
        return redirect()->route('login');
    }

}
