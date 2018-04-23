<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 22/03/2017
 * Time: 19:55
 */


namespace App\Http\Controllers;

use App\CusstomPHP\KhachHangFacebook;
use App\CusstomPHP\Logs;
use App\CusstomPHP\Response;
use App\CusstomPHP\SentHTTP;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class KhachHangController extends Controller{
    public function mainKH()
    {
        return view('page.khachhang.khachhang',[
            'khachhangs'=>\DB::table(Tables::$tb_khachhangs)->get(),
        ]);
    }

    public function getKhachHang(Request $request)
    {
        if($request->exists('type')){
            if($request->get('type')=='all'){
                return response(json_encode(\DB::table(Tables::$tb_khachhangs)->get()),200,Response::$jsonHeader);
            }
        }
        return response(json_encode(\DB::table(Tables::$tb_khachhangs)->where('id','=',$request->get('id'))->first()),200);
    }

    public function suaKhachHang(Request $request)
    {
        try{
            \DB::table(Tables::$tb_khachhangs)->where('id','=',$request->get('id'))->update([
                'hoten'=>$request->get('hoten'),
                'gioitinh'=>$request->get('gioitinh'),
                'sdt'=>$request->get('sdt'),
                'diachi'=>$request->get('diachi'),
                'ngaysua'=>Time::now(),
                'diem'=>$request->get('diem'),
                'luot'=>$request->get('luot'),
                'trangthai'=>$request->get('trangthai'),
                'ghichu'=>$request->get('ghichu')
            ]);
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }
    public function themKhachHang(Request $request)
    {
        try{
            $id=\DB::table(Tables::$tb_khachhangs)->insertGetId([
                'hoten'=>$request->get('hoten'),
                'gioitinh'=>$request->get('gioitinh'),
                'sdt'=>$request->get('sdt'),
                'diachi'=>$request->get('diachi'),
                'chinhanh'=>$request->get('chinhanh'),
                'ngaytao'=>Time::now(),
                'ngaysua'=>Time::now(),
                'diem'=>0,
                'luot'=>0,
                'trangthai'=>State::$tt_Kichhoat,
                'ghichu'=>''
            ]);
            return response('{"id":'.$id.',"success":true}',200,Response::$jsonHeader);
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
    }


    public function xoaKhachHang(Request $request)
    {
        try{
            \DB::table(Tables::$tb_khachhangs)->where('id','=',$request->get('id'))->delete();
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }


    public function loaiboTrung()
    {
        try{
            \DB::table(Tables::$tb_khachhangs)->where([
                ['sdt','=',''],
                ['id_fb','=','']
            ])->delete();
        }catch (\Exception $ex){
            return response(Response::$error,200,Response::$jsonHeader);
        }
        return response(Response::$succ,200,Response::$jsonHeader);
    }

    public function facebook(Request $request)
    {
        try{
            if (isset($_REQUEST['hub_challenge'])) {
                return $_REQUEST['hub_challenge'];
            }
            //lấy thông tin gửi từ server
            $input = json_decode(\Request::getContent());
            Logs::log(json_encode($input));
            $ID_GUI = $input->entry[0]->messaging[0]->sender->id;

            //Kiểm tra khách hàng đẫ tồn tại chưa, nếu chưa thì thêm vào csdl
            if(!\DB::table(Tables::$tb_khachhangs)->where('id_fb','=',$ID_GUI)->exists()){
                $khachang = json_decode(SentHTTP::SentGET(SentHTTP::$urlFB.$ID_GUI."?access_token=".Tables::getValue('token',Tables::$tb_khachhang_cauhinhs)));
                \DB::table(Tables::$tb_khachhangs)->insert([
                    'hoten'=>$khachang->first_name.' '.$khachang->last_name,
                    'anh'=>$khachang->profile_pic,
                    'gioitinh'=>$khachang->gender,
                    'ngaytao'=>Time::now(),
                    'ngaysua'=>Time::now(),
                    'diem'=>0,
                    'id_fb'=>$ID_GUI,
                    'trangthai'=>State::$tt_Kichhoat,
                ]);
            };

             //Xử lí thông tin
            KhachHangFacebook::xuli($input,$ID_GUI);

            return response(Response::$succ,200,Response::$jsonHeader);
        }catch (\Exception $ex){
            Logs::log(json_encode($ex));
            return response(Response::$error,200,Response::$jsonHeader);
        }
    }
}