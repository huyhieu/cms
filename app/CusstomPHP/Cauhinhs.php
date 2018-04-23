<?php

namespace App\CusstomPHP;



class Cauhinhs{

    public static function getCauHinh($name)

    {
    	$user_id=\Auth::id();
        $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();
        return \DB::table(Tables::$tb_cauhinhs)->where('name','=',$name)->where('daily','=',$user->daily)->first(['value'])->value;

    }



}