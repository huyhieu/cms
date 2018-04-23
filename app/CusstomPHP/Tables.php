<?php
namespace App\CusstomPHP;

use DB;

class Tables{
    public static $tb_User='users';
    public static $tb_khachhangs='khachhangs';
    public static $tb_khachhang_vouchers='khachhang_vouchers';
    public static $tb_khachhang_cauhinhs='khachhang_cauhinhs';
    public static $tb_sanphams='sanphams';
    public static $tb_cauhinhs='cauhinhs';
    public static $tb_hoadons='hoadons';
    public static $tb_logs='logs';
    public static $tb_sanpham_hoadons='hoadon_sanphams';
    public static $tb_chinhanhs='chinhanhs';
    public static $tb_sanpham_chuyenhangs='sanpham_chuyenhangs';
    public static $tb_sanpham_nhaphangs='sanpham_nhaphangs';
    public static $tb_sanpham_dathangs='sanpham_dathangs';

    public static function getValue($column,$table)
    {
        $data=DB::table($table)->first([$column]);
        return $data->$column;
    }

    public static function getColumns($table_name)
    {
        $columns = DB::select('show columns from ' . $table_name);
        $columns_names=[];
        foreach ($columns as $value) {
            array_push($columns_names,$value->Field);
        }
        return $columns_names;
    }

    public static function getDataJquery($table_name)
    {
        $js_data="";
        foreach(Tables::getColumns($table_name) as $item){
            $js_data=$js_data.$item.':'."$('#".$item."').val(), ";
        }
        return $js_data." _token:'".csrf_token()."'";
    }
    public static function setDataJquery($table_name)
    {
        $js_data="";
        foreach(Tables::getColumns($table_name) as $item){
            $js_data=$js_data."$('#".$item."').val(result['".$item."']);";
        }
        return $js_data;
    }
}