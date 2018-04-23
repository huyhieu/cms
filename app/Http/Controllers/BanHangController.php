<?php

namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Tables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class BanHangController extends Controller
{
    public function banhang(Request $request)
    {
        $user_id=\Auth::id();
        $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();
        $chinhanh=\DB::table(Tables::$tb_chinhanhs)->where('ma_cn','=',$user->daily)->first();
        if($user!=null){
            return view('page.banhang.banhang',[
                'khachhangs'=>\DB::table(Tables::$tb_khachhangs)->get(),
                'nhanvien'=>$user,
                'daily'=>$chinhanh,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function offline()
    {
        $data=view('page.banhang.offline')->render();
        return response($data,200,[
            'Content-Type'=>'text/plain'
        ]);
    }
}