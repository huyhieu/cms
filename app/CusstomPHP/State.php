<?php
namespace App\CusstomPHP;

class State{
    public static $tt_HoatDong="HOATDONG";
    public static $txt_HoatDong="Hoạt động";
    public static $tt_VoHieuHoa="VOHIEUHOA";
    public static $txt_VoHieuHoa="Vô hiệu hóa";
    public static $tt_DaNap="DANAP";
    public static $txt_DaNap="Đã nạp";
    public static $tt_Kichhoat="KICHHOAT";
    public static $txt_Kichhoat="Kích hoạt";
    public static $tt_Hoantat="HOANTAT";
    public static $tt_Nolai="NOLAI";
    public static $tt_DangCho="DANGCHO";
    public static $tt_DaKhoiPhuc="DAKHOIPHUC";
    public static $tt_thanhtoan="THANHTOAN";
    public static $tt_an="AN";

    public static function getTxtState($tt)
    {
        if($tt==State::$tt_HoatDong){
            return State::$txt_HoatDong;
        }
        if($tt==State::$tt_VoHieuHoa){
            return State::$txt_VoHieuHoa;
        }
        if($tt==State::$tt_DaNap){
            return State::$txt_DaNap;
        }
        if($tt==State::$tt_Kichhoat){
            return State::$txt_Kichhoat;
        }
        if($tt==State::$tt_Hoantat){
            return "Hoàn tất";
        }
        if($tt==State::$tt_Nolai){
            return "Nợ lại";
        }
        if($tt==State::$tt_DangCho){
            return "Đang chờ";
        }
        if($tt==State::$tt_DaKhoiPhuc){
            return "Đã khôi phục";
        }
        if($tt==State::$tt_thanhtoan){
            return "Thanh toán";
        }
        return null;
    }

}