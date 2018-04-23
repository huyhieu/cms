<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 24/03/2017
 * Time: 13:28
 */

namespace App\Http\Controllers;

use App\CusstomPHP\Response;
use App\CusstomPHP\SentHTTP;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class TrangChuController extends Controller{
    public function getTrangChu()
    {
        $khachhangs=\DB::table(Tables::$tb_khachhangs)->get();
        $hoadons=\DB::table(Tables::$tb_hoadons)->get([
            'id','daily_hd','ma_hd','id_kh','hoten_kh','tongtien_hd','tongtienKM_hd','ngaytao','ngaysua','trangthai','ghichu'
        ]);
        $hanghoas=\DB::table(Tables::$tb_sanphams)->get();
        $chinhanhs=\DB::table(Tables::$tb_chinhanhs)->get();
        $giatrihang=\DB::table(Tables::$tb_sanphams)->sum('gia_sp');
        $giatrivoucher=\DB::table(Tables::$tb_khachhang_vouchers)->sum('value');
        $tuongtac=\DB::table(Tables::$tb_logs)->get();

        return view('page.trangchu.trangchu',[
            'khachhangs'=>$khachhangs,
            'hoadons'=>$hoadons,
            'sanphams'=>$hanghoas,
            'giatrihang'=>$giatrihang,
            'giatrivoucher'=>$giatrivoucher,
            'tuongtac'=>$tuongtac,
            'chinhanhs'=>$chinhanhs,
        ]);
    }
}