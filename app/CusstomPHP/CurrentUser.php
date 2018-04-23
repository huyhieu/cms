<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 31/03/2017
 * Time: 12:54
 */

namespace App\CusstomPHP;
use App\Http\Controllers\NhanVienController;

class CurrentUser{
    public static function user()
    {
        if(\Auth::check()){
            return \DB::table(Tables::$tb_User)->where('id','=',\Auth::id())->first();
        }else{
            return null;
        }
    }

    public static function level()
    {
        if(\Auth::check()){
            $user= \DB::table(Tables::$tb_User)->where('id','=',\Auth::id())->first();
            if($user->level==NhanVienController::$NHANVIEN){
                return NhanVienController::$txtNHANVIEN;
            }else{
                return NhanVienController::$txtQUANLY;
            }
        }else{
            return null;
        }
    }

    public static function levelTT()
    {
        if(\Auth::check()){
            $user= \DB::table(Tables::$tb_User)->where('id','=',\Auth::id())->first();
            return $user->level;
        }else{
            return null;
        }
    }

    public static function name()
    {
        if(\Auth::check()){
            return \DB::table(Tables::$tb_User)->where('id','=',\Auth::id())->first()->name;
        }else{
            return null;
        }
    }
}