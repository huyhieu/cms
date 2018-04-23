<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 24/03/2017
 * Time: 12:58
 */

namespace App\CusstomPHP;

class Response{
    public static $succ='{"success":true}';
    public static $error='{"success":false}';
    public static $jsonHeader=array('content-type'=>'application/json; charset=UTF-8');


    public static function jsonHeaderWithLength($length)
    {
        return array(
            'content-type'=>'application/json; charset=UTF-8',
            'Content-Length'=>$length,
            'Accept-Ranges'=>'bytes'
        );
    }
}