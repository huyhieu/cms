<?php
namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class ChiNhanhController extends Controller
{
    public function getChiNhanh()
    {
        $user_id=\Auth::id();
        $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();
        if($user->daily == 'SUPER')
            $dailys = \DB::table(Tables::$tb_chinhanhs)->get();
        else
            $dailys = \DB::table(Tables::$tb_chinhanhs)->where('ma_cn','=',$user->daily)->get();
        return view('page.chinhanh.chinhanh', [
            'chinhanhs' => $dailys
        ]);
    }

    public function themChiNhanh(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_chinhanhs);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['id'] = null;
            $data['ngaytao'] = Time::now();
            $data['ngaysua'] = Time::now();

            if (\DB::table(Tables::$tb_chinhanhs)->insert($data)) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function suaChiNhanh(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_chinhanhs);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            unset($data['ngaytao']);
            $data['ngaysua'] = Time::now();

            if (\DB::table(Tables::$tb_chinhanhs)->where('id', '=', $data['id'])->update($data)) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function xoaChiNhanh(Request $request)
    {
        try {

            $id = $request->get('id');

            if (\DB::table(Tables::$tb_chinhanhs)->where('id', '=', $id)->delete()) {
                return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
            } else {
                return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
            }
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
}
