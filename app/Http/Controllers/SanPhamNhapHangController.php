<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 05/04/2017
 * Time: 17:19
 */

namespace App\Http\Controllers;


use App\CusstomPHP\Tables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SanPhamNhapHangController extends Controller
{
    public function get()
    {
        $id = \Auth::id();
        $daily_user = \DB::table(Tables::$tb_User)->where('id', '=', $id)->first()->daily;
        return view('page.sanpham.nhaphang', [
            'nhaphangs' => \DB::table(Tables::$tb_sanpham_nhaphangs)->get(),
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
            'dailyhientai' => $daily_user,
        ]);
    }
    public function getNhapKho()
    {
        return view('page.sanpham.nhapkho', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }

    public function getLichSu()
    {
//        $user_id=\Auth::id();
//        $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();
//        if($user->daily == 'SUPER')
//            $dailys = \DB::table(Tables::$tb_chinhanhs)->get();
//        else
//            $dailys = \DB::table(Tables::$tb_chinhanhs)->where('ma_cn','=',$user->daily)->get();
//
//        $allSanPham =  \DB::table(Tables::$tb_sanphams)->where('trangthai','<>',State::$tt_an)->where('daily_sp', '=', $dailys)->get();
        $lsSanPhams = \DB::table(Tables::$tb_sanpham_nhaphangs)->get();
//        if($user->daily != 'SUPER'){
//            foreach ($lsSanPhams as $lsSanPham) {
//
//            }
//        }
        return view('page.sanpham.lichsu_nhaphang', [
            'nhaphangs' => $lsSanPhams
        ]);
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->get('id');
            \DB::table(Tables::$tb_sanpham_nhaphangs)->where('id', '=', $id)->delete();
            return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
}