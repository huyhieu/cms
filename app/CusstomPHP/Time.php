<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 21/03/2017
 * Time: 15:11
 */
namespace App\CusstomPHP;

use Carbon\Carbon;
use DB;

class Time{
    public static function now()
    {
        return Carbon::now("Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
    }

    public static function hom30day()
    {
        $now=Carbon::now("Asia/Ho_Chi_Minh");
        $next=$now->addMonth();
        $next=$next->addMonth();
        return Time::Timenow().' '.$next->format("d/m/Y");
    }

    public static function homsau24h()
    {
        return Time::Timenow().' '.Carbon::tomorrow("Asia/Ho_Chi_Minh")->format("d/m/Y");
    }
    public static function Datenow()
    {
        return Carbon::now("Asia/Ho_Chi_Minh")->format("d/m/Y");
    }
    public static function DatenowFILE()
    {
        return Carbon::now("Asia/Ho_Chi_Minh")->format("d_m_Y_H_i");
    }
    public static function Timenow()
    {
        return Carbon::now("Asia/Ho_Chi_Minh")->format("H:i");
    }
}