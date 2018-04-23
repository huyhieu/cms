<?php

namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        if($request->exists('submit')){
            if(\Auth::attempt(['username'=>$request->get('username'),'password'=>$request->get('password')],true)){
                if(\App\CusstomPHP\CurrentUser::levelTT()==\App\Http\Controllers\NhanVienController::$NHANVIEN){
                    return redirect()->route('banhang');
                }else{
                    return redirect()->route('get-hoadon');
                }
            }else{
                \Session::flash('message_login','Sai tên đang nhập hoặc mật khẩu!');
            }
        }
        return view('page.login.login');
    }
}