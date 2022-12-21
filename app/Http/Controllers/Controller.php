<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function GetUrlPrefix()
    {
        return Request()->session()->get('prefix');
    }

    public static function isAdminPage()
    {
        return (Controller::GetUrlPrefix() == 'admin') ? true : false;
    }

    public function UbahPassword(Request $request)
    {
        $user = User::where('user_code', $request->user_code)->first();
        $user->password = bcrypt($request->password);
        $message = null;
        if ($user->save()) {
            $message = 'Berhasil Ubah Password';
        }else{
            $message = 'Gagal Ubah Password';
        }
        return response()->json($message);
    }

    public function ResetPassword($user_code)
    {
        try {
            $user = User::where('user_code', $user_code)->first();
            $user->password = bcrypt($user_code);
            $user->save();
            return redirect()->back()->with('success', 'Password barhasil di reset');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
