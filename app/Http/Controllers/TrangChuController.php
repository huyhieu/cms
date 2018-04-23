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
use App\CusstomPHP\State;
use Illuminate\Routing\Controller;


class TrangChuController extends Controller{
    public function getTrangChu()
    {
        $user_id=\Auth::id();
        $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();

        $khachhangs=\DB::table(Tables::$tb_khachhangs)->get();
        $hoadons=\DB::table(Tables::$tb_hoadons)->where('daily_hd', '=', $user->daily)->get([
            'id','daily_hd','ma_hd','id_kh','hoten_kh','tongtien_hd','tongtienKM_hd','ngaytao','ngaysua','trangthai','ghichu'
        ]);
        $hanghoas=\DB::table(Tables::$tb_sanphams)->where('trangthai','<>',State::$tt_an)
            ->where('daily_sp', '=', $user->daily)->get();

        if($user->daily == 'SUPER')
            $dailys = \DB::table(Tables::$tb_chinhanhs)->get();
        else
            $dailys = \DB::table(Tables::$tb_chinhanhs)->where('ma_cn','=',$user->daily)->get();

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
            'chinhanhs'=>$dailys,
        ]);
    }
}