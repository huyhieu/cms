<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 24/03/2017
 * Time: 13:28
 */

namespace App\Http\Controllers;

use App\CusstomPHP\Logs;
use App\CusstomPHP\Response;
use App\CusstomPHP\SentHTTP;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class KhachHangVoucherController extends Controller{

    public function mainKHVoucher()
    {
        return view('page.khachhang.khachhang_vouchers',[
            'vouchers'=>\DB::table(Tables::$tb_khachhang_vouchers)->get(),
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }

    public function getKhachHangVoucher(Request $request)
    {
        if($request->exists('type')){
            if($request->get('type')=='all'){
                return response(json_encode(\DB::table(Tables::$tb_khachhang_vouchers)->get()),200,Response::$jsonHeader);
            }
        }
        return response(json_encode(\DB::table(Tables::$tb_khachhang_vouchers)->where('id','=',$request->get('id'))->first()),200);
    }

    public function xoaKhachHangVoucher(Request $request)
    {
        try{
            \DB::table(Tables::$tb_khachhang_vouchers)->where('id','=',$request->get('id'))->delete();
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }

    public function suaKhachHangVoucher(Request $request)
    {
        try{
            \DB::table(Tables::$tb_khachhang_vouchers)->where('id','=',$request->get('id'))->update([
                'code'=>$request->get('code'),
                'value'=>$request->get('value'),
                'hethan'=>$request->get('hethan'),
                'ngaysua'=>Time::now(),
                'trangthai'=>$request->get('trangthai'),
                'ghichu'=>$request->get('ghichu')
            ]);
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }


    public function themKhachHangVoucher(Request $request)
    {
        try{
            \DB::table(Tables::$tb_khachhang_vouchers)->insert([
                'code'=>$request->get('code'),
                'value'=>$request->get('value'),
                'hethan'=>$request->get('hethan'),
                'ngaytao'=>Time::now(),
                'ngaysua'=>Time::now(),
                'trangthai'=>$request->get('trangthai'),
                'ghichu'=>$request->get('ghichu')
            ]);
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }

    public static function taoVoucher($value,$time,$daily_hd)
    {
        $code=rand(100000,999999);
        while(\DB::table(Tables::$tb_khachhang_vouchers)->where('code','=',$code)->exists()){
            $code=rand(100000,999999);
        }
        DB::table(Tables::$tb_khachhang_vouchers)->insert([
            'daily'=>$daily_hd,
            'code'=>$code,
            'value'=>$value,
            'hethan'=>$time,
            'ngaytao'=>Time::now(),
            'ngaysua'=>Time::now(),
            'trangthai'=>State::$tt_HoatDong
        ]);
        return $code;
    }
    //tạo mã cho khách hàng thanh toán
    public static function taoVoucherKH($value,$time)
    {
        $code=rand(100000,999999);
        while(\DB::table(Tables::$tb_khachhang_vouchers)->where('code','=',$code)->exists()){
            $code=rand(100000,999999);
        }
        DB::table(Tables::$tb_khachhang_vouchers)->insert([
            'code'=>$code,
            'value'=>$value,
            'hethan'=>$time,
            'ngaytao'=>Time::now(),
            'ngaysua'=>Time::now(),
            'trangthai'=>State::$tt_thanhtoan
        ]);
        return $code;
    }

    public static function loaiBoMaKH($code)
    {
        try{
            \DB::table(Tables::$tb_khachhang_vouchers)->where('code','=',$code)->update([
                'trangthai'=>State::$tt_DaNap,
            ]);
            \DB::table(Tables::$tb_khachhangs)->where('code','=',$code)->update([
                'code'=>''
            ]);
        }catch (\Exception $ex){
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
    }

    public static function giamdiemKH($id_kh,$diem_tru)
    {
        try{
            \DB::table(Tables::$tb_khachhangs)->where('id','=',$id_kh)->decrement('diem',$diem_tru);
        }catch (\Exception $ex){
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
    }

    public function getgiatriVC(Request $request)
    {
        try{
            $vc=\DB::table(Tables::$tb_khachhang_vouchers)->where('code','=',$request->get('code'))->first();
            if($vc->trangthai==State::$tt_thanhtoan){
                $hethan=$vc->hethan;
                $now=Carbon::now("Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
                $now=Carbon::createFromFormat('H:i d/m/Y',$now,"Asia/Ho_Chi_Minh");
                $hethan=Carbon::createFromFormat('H:i d/m/Y',$hethan,"Asia/Ho_Chi_Minh");
                if($now->lte($hethan)){
                    $tien=floatval($vc->value)*floatval(\App\CusstomPHP\Tables::getValue('donvi_diem',\App\CusstomPHP\Tables::$tb_khachhang_cauhinhs));
                    $tien=intval($tien);
                    return response('{"success":true, "tien":'.$tien.'}',200,Response::$jsonHeader);
                }else{
                    return response(Response::$error,200,Response::$jsonHeader);
                }
            }else{
                return response(Response::$error,200,Response::$jsonHeader);
            }
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
    }

    //Làm sạch vc cũ
    public function lamsachVCcu()
    {
        try{
            $data=\DB::table(Tables::$tb_khachhang_vouchers)->get();
            foreach($data as $item){
                $hethan = $item->hethan;
                $now = Carbon::now("Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
                $now = Carbon::createFromFormat('H:i d/m/Y', $now, "Asia/Ho_Chi_Minh");
                $hethan = Carbon::createFromFormat('H:i d/m/Y', $hethan, "Asia/Ho_Chi_Minh");
                if (!$now->lte($hethan)) {
                    \DB::table(Tables::$tb_khachhang_vouchers)->where('id','=',$item->id)->delete();
                }
            }
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }
}