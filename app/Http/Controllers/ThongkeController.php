<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 05/04/2017
 * Time: 12:54
 */

namespace App\Http\Controllers;


use App\CusstomPHP\Tables;
use Illuminate\Routing\Controller;

class ThongkeController extends Controller
{
    public function sanpham()
    {
        return view('page.thongke.sanphambanchay',[
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }
    public function sanphambancham()
    {
        return view('page.thongke.sanphambancham',[
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }
    public function banhang()
    {
        return view('page.thongke.banhang',[
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }
    public function khachhang()
    {
        return view('page.thongke.khachhang',[
            'chinhanhs'=>\DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }
}