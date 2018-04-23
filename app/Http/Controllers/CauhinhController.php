<?php
namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Tables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class CauhinhController extends Controller
{
    public function getCauhinh()
    {
        return view('page.cauhinh.cauhinh');
    }

    public function luuCauhinh(Request $request)
    {
        $user_id=\Auth::id();
        $user=\DB::table(Tables::$tb_User)->where('id','=',$user_id)->first();       
        
        \DB::table(Tables::$tb_cauhinhs)->where('name','=','hoadon_template')->where('daily','=',$user->daily)->update([
           'value'=>$request->get('hoadon_template'),
        ]);
        \DB::table(Tables::$tb_cauhinhs)->where('name','=','phamtramtich')->where('daily','=',$user->daily)->update([
           'value'=>$request->get('phamtramtich'),
        ]);
        \DB::table(Tables::$tb_cauhinhs)->where('name','=','phamtramtichSN')->where('daily','=',$user->daily)->update([
           'value'=>$request->get('phamtramtichSN'),
        ]);
        \DB::table(Tables::$tb_cauhinhs)->where('name','=','listbotich')->where('daily','=',$user->daily)->update([
           'value'=>$request->get('listbotich'),
        ]);
        \DB::table(Tables::$tb_cauhinhs)->where('name','=','muatoithieu')->where('daily','=',$user->daily)->update([
           'value'=>$request->get('muatoithieu'),
        ]);
        return redirect()->route('get-cauhinh');
    }
}
