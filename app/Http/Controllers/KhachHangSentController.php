<?php
namespace App\Http\Controllers;

use App\CusstomPHP\Tables;
use Illuminate\Routing\Controller;

class KhachHangSentController extends Controller{
    public function getSent()
    {
        return view('page.khachhang.khachhang_sent',[
            'khachhangs'=>\DB::table(Tables::$tb_khachhangs)->get(),
        ]);
    }
}