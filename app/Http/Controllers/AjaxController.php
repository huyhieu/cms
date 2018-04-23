<?php
/**
 *
 */

namespace App\Http\Controllers;


use App\CusstomPHP\CurrentUser;
use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Response;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AjaxController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            //Kiểm tra đại lí
            $id = \Auth::id();
            $user = \DB::table(Tables::$tb_User)->where('id', '=', $id)->first();
            $daily_user = $user->daily;

            $table_name = $request->get('table');
            //bảng sản phẩm
            if ($table_name == Tables::$tb_sanphams) {
                if ($daily_user == 'SUPER') {
                    $string_dulieu = json_encode(\DB::table($table_name)->where('trangthai','<>',State::$tt_an)->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                } else {
                    $string_dulieu = json_encode(\DB::table($table_name)->where('trangthai','<>',State::$tt_an)->where('daily_sp', '=', $daily_user)
                        ->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                }
            }

            if ($table_name == Tables::$tb_khachhangs) {
                if ($daily_user == 'SUPER') {
                    $string_dulieu = json_encode(\DB::table($table_name)->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                } else {
                    $string_dulieu = json_encode(\DB::table($table_name)->where('chinhanh', '=', $daily_user)
                        ->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                }
            }
            if ($table_name == Tables::$tb_hoadons) {
                if ($daily_user == 'SUPER') {
                    $string_dulieu = json_encode(\DB::table($table_name)->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                } else {
                    $string_dulieu = json_encode(\DB::table($table_name)->where('daily_hd', '=', $daily_user)
                        ->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                }
            }

            //bảng khác
            return response(json_encode(\DB::table($table_name)->get()), 200, Response::$jsonHeader);
            //return response(json_encode(\DB::table($table_name)->when('daily_sp', '=', $daily_user)), 200, Response::$jsonHeader);


        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
    
    public function getAllKhanhHangForBanHang(Request $request)
    {
        try {
            //Kiểm tra đại lí
            $id = \Auth::id();
            $user = \DB::table(Tables::$tb_User)->where('id', '=', $id)->first();
            $daily_user = $user->daily;

            $table_name = $request->get('table');
            
            if ($table_name == Tables::$tb_khachhangs) {
                    $string_dulieu = json_encode(\DB::table($table_name)->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
            }
            
            //bảng khác
            return response(json_encode(\DB::table($table_name)->get()), 200, Response::$jsonHeader);
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function getAllSanPhamByDaily(Request $request)
    {
        try {
            //Kiểm tra đại lí
            $id = \Auth::id();
            $user = \DB::table(Tables::$tb_User)->where('id', '=', $id)->first();
            $daily_user = $user->daily;
            $table_name = $request->get('table');
            return response(json_encode(\DB::table($table_name)->where('daily_sp', 'like', $daily_user)->get()), 200, Response::$jsonHeader);
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }


    public function getSanphamAN(Request $request)
    {
        try {
            //Kiểm tra đại lí
            $id = \Auth::id();
            $user = \DB::table(Tables::$tb_User)->where('id', '=', $id)->first();
            $daily_user = $user->daily;

            $table_name = $request->get('table');
            //bảng sản phẩm
            if ($table_name == Tables::$tb_sanphams) {
                if ($daily_user == 'KHO') {
                    $string_dulieu = json_encode(\DB::table($table_name)->where('trangthai','=',State::$tt_an)->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                } else {
                    $string_dulieu = json_encode(\DB::table($table_name)->where('trangthai','=',State::$tt_an)->where('daily_sp', '=', $daily_user)
                        ->get());
                    return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
                }
            }
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function getsanphamKHO(Request $request)
    {
        try {
            $user_id=\Auth::id();
            $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();

            //Kiểm tra đại lí
            $table_name = $request->get('table');
            if ($table_name == Tables::$tb_sanphams) {
                $string_dulieu = json_encode(\DB::table($table_name)->where('daily_sp', '=', $user->daily)
                    ->get());
                return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));
            }
            return response(json_encode(\DB::table($table_name)->get()), 200, Response::$jsonHeader);


        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function getbyColumn(Request $request)
    {
        try {
            if ($request->ajax()) {
                $table_name = $request->get('table');
                $column = $request->get('column');
                return response(json_encode(\DB::table($table_name)->get([$column])), 200, Response::$jsonHeader);
            } else {
                return redirect()->route('login');
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    //Lấy hóa đơn ngày hôm nay
    public function gethoadonTODAY()
    {
        try {
            $string_dulieu = json_encode(\DB::table(Tables::$tb_hoadons)->where([
                ['ngaytao', 'LIKE', '%'.Time::Datenow()],
                ['daily_hd', '=', CurrentUser::user()->daily]
            ])->get());
            return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));

        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    //Lấy hóa đơn ngày hôm nay
    public function nhomlichsuchuyenhan()
    {
        try {
            $string_dulieu = json_encode(\DB::select("SELECT `daily_gui`,`daily_nhan`,COUNT(`id_sp_gui`) as 'SL_SP', SUM(`sl`) as 'TONGSL_SP',`ngaytao` FROM `sanpham_chuyenhangs` WHERE 1 GROUP BY `daily_gui`,`daily_nhan`,`ngaytao`"));
            return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));

        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
    //Lấy hóa đơn ngày hôm nay
    public function nhomlichsunhap()
    {
        try {
            $string_dulieu = json_encode(\DB::select("SELECT `daily_gui`,`daily_nhan`,COUNT(`id_sp_gui`) as 'SL_SP', SUM(`sl`) as 'TONGSL_SP',`ngaytao` FROM `sanpham_chuyenhangs` WHERE 1 GROUP BY `daily_gui`,`daily_nhan`,`ngaytao`"));
            return response($string_dulieu, 200, Response::jsonHeaderWithLength(mb_strlen($string_dulieu)));

        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
}