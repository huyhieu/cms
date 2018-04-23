<?php
namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class NhanVienController extends Controller
{
    public static $NHANVIEN='NHANVIEN';
    public static $txtNHANVIEN='Nhân viên';
    public static $QUANLY='QUANLY';
    public static $txtQUANLY='Quản lý';


    public function getNhanVien()
    {
        return view('page.nhanvien.nhanvien', [
            'nhanviens' => \DB::table(Tables::$tb_User)->get(),
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
            'txtNHANVIEN'=>NhanVienController::$txtNHANVIEN,
            'txtQUANLY'=>NhanVienController::$txtQUANLY,
            'QUANLY'=>NhanVienController::$QUANLY,
            'NHANVIEN'=>NhanVienController::$NHANVIEN,
        ]);
    }

    public function themNhanVien(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_User);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['id'] = null;
            $data['password']=\Hash::make($data['password']);
            $data['created_at'] = Time::now();
            $data['updated_at'] = Time::now();

            if (\DB::table(Tables::$tb_User)->insert($data)) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function suaNhanVien(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_User);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            if($data['password']==''){
                unset($data['password']);
            }else{
                $data['password']=\Hash::make($data['password']);
            }
            unset($data['created_at']);
            $data['updated_at'] = Time::now();

            if (\DB::table(Tables::$tb_User)->where('id', '=', $data['id'])->update($data)) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function xoaNhanVien(Request $request)
    {
        try {
            $id = $request->get('id');

            if (\DB::table(Tables::$tb_User)->where('id', '=', $id)->delete()) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
}
