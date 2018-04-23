<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 15/04/2017
 * Time: 09:35
 */

namespace App\Http\Controllers;


use App\CusstomPHP\Tables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SanPhamDoiGiaController extends Controller
{
    public function get()
    {
        return view('page.sanpham.doigia', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }

    public function set(Request $request)
    {
        $sanphams=$request->get('sanphams');
        $sanphams=json_decode($sanphams);
        foreach($sanphams as $item){
            \DB::table(Tables::$tb_sanphams)->where('id','=',$item->id)->update([
               'giaKM_sp'=> $item->giaNEW_sp
            ]);
        }
        return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
    }
}