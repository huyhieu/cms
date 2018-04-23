<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 19/03/2017
 * Time: 16:38
 */
namespace App\CusstomPHP;

class AssetFile{

    public static function css($filename)
    {
        return "<link href='".\URL::asset('css/'.$filename,CustomURL::$SSL)."' rel='stylesheet'>";
    }
    public static function js($filename)
    {
        return "<script src='".\URL::asset('js/'.$filename,CustomURL::$SSL)."'></script>";
    }
    public static function file($filename)
    {
        return \URL::asset($filename,CustomURL::$SSL);
    }

    public static function fileNOTpublic($filename)
    {
        return \URL::asset($filename,CustomURL::$SSL);
    }

    public static function contentCSS($filename)
    {
        return "<style>". \File::get('css/'.$filename)."</style>";
    }
}