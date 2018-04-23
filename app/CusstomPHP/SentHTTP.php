<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 22/03/2017
 * Time: 20:55
 */
namespace App\CusstomPHP;

class SentHTTP{
    public static $urlFB="https://graph.facebook.com/v2.8/";
    //Hàm gửi curl
    public static function SentPOSTFacebook($url,$data_json)
    {
        $ch = curl_init($url . "?access_token=" . Tables::getValue('token',Tables::$tb_khachhang_cauhinhs));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //Gửi get
    public static function SentGETFacebook($url)
    {
        $ch = curl_init($url . "&access_token=" . Tables::getValue('token',Tables::$tb_khachhang_cauhinhs));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    //Gửi get tùy biến
    public static function SentGET($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    //Gửi post
    public static function SentPOST($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, null);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}