<?php

namespace App\Http\Controllers;

use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


class SanPhamController  extends Controller
{

    public function getView()
    {
        return view('page.sanpham.sanphams',[
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }


    public function checkSanpham(Request $request)
    {
        try{
            if(\DB::table(Tables::$tb_sanphams)->where('ma_sp','=',$request->get('ma_sp'))->exists()){
                return response(\App\CusstomPHP\Response::$succ,200,\App\CusstomPHP\Response::$jsonHeader);
            }else{
                return response(\App\CusstomPHP\Response::$error,200,\App\CusstomPHP\Response::$jsonHeader);
            }
        }catch (\Exception $ex){
            return response(\App\CusstomPHP\Response::$error,200,\App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function addSanpham(Request $request){
        //try{
            $hoanthanh=false;
            $fields=Tables::getColumns(Tables::$tb_sanphams);
            $data=array();
            foreach($fields as $item){
                if($request->exists($item)){
                    $data[$item]=$request->get($item);
                }
            }
            $data['ngaytao']=Time::now();
            $data['ngaysua']=Time::now();

            //Kiểm tra dữ liệu
            if($data['ma_sp']==''){
                return response(\App\CusstomPHP\Response::$error,200,\App\CusstomPHP\Response::$jsonHeader);
            }
            //Kiểm tra cập nhật sl hay thêm mới hàng
            if(\DB::table(Tables::$tb_sanphams)->where([
                ['ma_sp','=',$data['ma_sp']],
                ['daily_sp','=',$data['daily_sp']]])->exists()){
                $sanpham=\DB::table(Tables::$tb_sanphams)->where([
                    ['ma_sp','=',$data['ma_sp']],
                    ['daily_sp','=',$data['daily_sp']]
                ])->first();
                if(\DB::table(Tables::$tb_sanphams)->where('id','=',$sanpham->id)->update([
                    'SL_sp'=>(intval($sanpham->SL_sp)+intval($data['SL_sp'])),
                    'giaNHAP_sp'=>$data['giaNHAP_sp'],
                    'ngaysua'=>Time::now()
                ])){
                    $hoanthanh=true;
                }
            }else{
                if(\DB::table(Tables::$tb_sanphams)->insert($data)){
                    $hoanthanh=true;
                }
            }

            if($hoanthanh){
                $sanpham=\DB::table(Tables::$tb_sanphams)->where([
                    ['ma_sp','=',$data['ma_sp']],
                    ['daily_sp','=',$data['daily_sp']]
                ])->first();
                //Lưu vào bảng nhập hàng
                \DB::table(Tables::$tb_sanpham_nhaphangs)->insert([
                    'ma_sp'=>$sanpham->ma_sp,
                    'ten_sp'=>$sanpham->ten_sp,
                    'gia_nhap'=>$data['giaNHAP_sp'],
                    'sl_nhap'=>$data['SL_sp'],
                    'ngaytao'=>Time::now(),
                    'trangthai'=>State::$tt_Hoantat,
                    'ghichu'=>$data['ghichu_sp'],
                ]);
                return response(json_encode($sanpham),200,\App\CusstomPHP\Response::$jsonHeader);
            }else{
                return response(\App\CusstomPHP\Response::$error,500,\App\CusstomPHP\Response::$jsonHeader);
            }

//        }catch (\Exception $ex){
//            return response(\App\CusstomPHP\Response::$error,500,\App\CusstomPHP\Response::$jsonHeader);
//        }
    }

    public function editSanpham(Request $request){
        $fields=Tables::getColumns(Tables::$tb_sanphams);
        $data=array();
        foreach($fields as $item){
            if($request->exists($item)){
                $data[$item]=$request->get($item);
            }
        }
        unset($data['id']);
        $data['ngaysua']=Time::now();

        if(\DB::table(Tables::$tb_sanphams)->where('id','=',$request->get('id'))->update($data)){
            return response(json_encode(\DB::table(Tables::$tb_sanphams)->where('id','=',$request->get('id'))->first()),200,\App\CusstomPHP\Response::$jsonHeader);
        }else{
            return response(\App\CusstomPHP\Response::$error,200,\App\CusstomPHP\Response::$jsonHeader);
        }
    }


    public function deleteSanpham(Request $request){
        if(\DB::table(Tables::$tb_sanphams)->where('id','=',$request->get('id'))->delete()){
            return response(\App\CusstomPHP\Response::$succ,200,\App\CusstomPHP\Response::$jsonHeader);
        }else{
            return response(\App\CusstomPHP\Response::$error,200,\App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function getSanpham(Request $request)
    {
        //dieukien: id,ma_sp...
        //giatri:0000
        if($request->exists('dieukien')){
            if($request->get('dieukien')=='id'){
                return json_encode(\DB::table(Tables::$tb_sanphams)->where('id','=',$request->get('giatri'))->first());
            }
        }else{
            $columms = array("id","ma_sp","ten_sp","loai_sp","SL_sp","giaNHAP_sp","donvi_sp","gia_sp","giaKM_sp","daily_sp","ngaytao","ngaysua","ghichu_sp");
            return '{"data": '.json_encode(\DB::table(Tables::$tb_sanphams)->get($columms)).'}';
        }
        return response(\App\CusstomPHP\Response::$succ,200,\App\CusstomPHP\Response::$jsonHeader);
    }
}