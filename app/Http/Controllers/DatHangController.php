<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 07/04/2017
 * Time: 14:08
 */

namespace App\Http\Controllers;


use App\CusstomPHP\Response;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DatHangController extends Controller
{
    public function getDatHang()
    {
        return view('page.sanpham.dathang',[
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
            'khachhangs'=>\DB::table(Tables::$tb_khachhangs)->get(),
        ]);
    }

    public function them(Request $request)
    {
        $columns=\App\CusstomPHP\Tables::getColumns(\App\CusstomPHP\Tables::$tb_sanpham_dathangs);
        $data=[];
        foreach($columns as $item){
            $data[$item]=$request->get($item);
        }
        //đổi trạng thái
        $data['trangthai']=State::$tt_DangCho;

        unset($data['id']);
        $data['ngaytao']=Time::now();
        $data['ngaysua']=Time::now();

        if(\DB::table(Tables::$tb_sanpham_dathangs)->insert($data)){
            return response(Response::$succ,200,Response::$jsonHeader);
        }else{
            return response(Response::$error,200,Response::$jsonHeader);
        }
    }

    public function sua(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_sanpham_dathangs);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['ngaysua']=Time::now();
            if (\DB::table(Tables::$tb_sanpham_dathangs)->where('id', '=', $data['id'])->update($data)) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
    public function xoa(Request $request)
    {
        try {
            if (\DB::table(Tables::$tb_sanpham_dathangs)->where('id', '=', $request->get('id'))->delete()) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function getsp(Request $request)
    {
        try {
            $data=\DB::table(Tables::$tb_sanpham_dathangs)->where('id','=',$request->get('id'))->first(['sanpham_muas'])->sanpham_muas;
            return response($data, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
}