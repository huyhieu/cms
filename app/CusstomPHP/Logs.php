<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 31/03/2017
 * Time: 14:00
 */
namespace App\CusstomPHP;

class Logs{
    public static function log($message)
    {
        \DB::table(Tables::$tb_logs)->insert([
            'message'=>$message,
            'ngaytao'=>Time::now()
        ]);
    }
}