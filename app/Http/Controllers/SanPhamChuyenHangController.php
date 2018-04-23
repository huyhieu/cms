<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 04/04/2017
 * Time: 17:13
 */
namespace App\Http\Controllers;

use App\CusstomPHP\Logs;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SanPhamChuyenHangController extends Controller
{

    public function get()
    {
        return view('page.sanpham.chuyenhang', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }

    public function getxuatkho()
    {
        return view('page.sanpham.xuatkho', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }

    public function getLichsu()
    {
        return view('page.sanpham.lichsu_chuyenhang', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
        ]);
    }

    public function chuyen(Request $request)
    {
        try {
            $daily_nhan = $request->get('daily_nhan');
            $data = $request->get('data');
            $sanphams = json_decode($data);
            foreach ($sanphams as $item) {
                //Láy sp
                $id_sp = $item->id;
                $sl_nhan = $item->sl_nhan;
                //Nạp lại dữ liệu
                $item = \DB::table(Tables::$tb_sanphams)->where('id', '=', $id_sp)->first();
                $ma_sp = $item->ma_sp;
                $SL_sp = $item->SL_sp;
                $daily_gui = $item->daily_sp;
                //Hiển thị hết lên
                \DB::table(Tables::$tb_sanphams)->where('ma_sp', 'LIKE', $ma_sp)->update([
                    'trangthai'=>''
                ]);
                $id_sp_nhan='';
                if (($daily_gui != $daily_nhan) || ($daily_nhan=='')) {
                    //Thêm sp vào đại lý nhận
                    $tontai = \DB::table(Tables::$tb_sanphams)->where([
                        ['ma_sp', '=', $ma_sp],
                        ['daily_sp', '=', $daily_nhan]
                    ])->exists();
                    if ($tontai == true) {
                        $sanpham_tontai = \DB::table(Tables::$tb_sanphams)->where([
                            ['ma_sp', '=', $ma_sp],
                            ['daily_sp', '=', $daily_nhan]
                        ])->first(['id','SL_sp']);
                        $id_sp_nhan=$sanpham_tontai->id;
                        \DB::table(Tables::$tb_sanphams)->where('id','=',$id_sp_nhan)->update([
                            'SL_sp' => (intval($sl_nhan) + intval($sanpham_tontai->SL_sp))
                        ]);
                    } else {
                        unset($item->sl_nhan);
                        unset($item->id);
                        $item->ngaytao = Time::now();
                        $item->ngaysua = Time::now();
                        $item->SL_sp = $sl_nhan;
                        $item->daily_sp = $daily_nhan;
                        //Logs::log(json_encode($item));
                        $id_sp_nhan=\DB::table(Tables::$tb_sanphams)->insertGetId([
                            'ma_sp' => $item->ma_sp,
                            'ten_sp' => $item->ten_sp,
                            'donvi_sp' => $item->donvi_sp,
                            'SL_sp' => $item->SL_sp,
                            'gia_sp' => $item->gia_sp,
                            'giaKM_sp' => $item->giaKM_sp,
                            'giaNHAP_sp' => $item->giaNHAP_sp,
                            'anh_sp' => $item->anh_sp,
                            'ngaytao' => $item->ngaytao,
                            'ngaysua' => $item->ngaysua,
                            'daily_sp' => $item->daily_sp,
                            'trangthai' => '',
                            'ghichu_sp' => $item->ghichu_sp
                        ]);
                    }
                    //Trừ đi tại đại lí gửi
                    \DB::table(Tables::$tb_sanphams)->where('id', '=', $id_sp)->update([
                        'SL_sp' => ($SL_sp - $sl_nhan)
                    ]);
                    //Lưu vào bảng chuyển
                    \DB::table(Tables::$tb_sanpham_chuyenhangs)->insert([
                        'daily_gui' => $daily_gui,
                        'daily_nhan' => $daily_nhan,
                        'id_sp_gui' => $id_sp,
                        'id_sp_nhan'=>$id_sp_nhan,
                        'ma_sp' => $item->ma_sp,
                        'ten_sp' => $item->ten_sp,
                        'sanpham' => json_encode($item),
                        'sl' => $sl_nhan,
                        'ngaytao' => Time::now(),
                        'trangthai' => State::$tt_Hoantat
                    ]);
                }
            }
            return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            Logs::log('ERROR: ' . $ex->getFile() . " LINE: " . $ex->getLine() . " FILE: " . $ex->getFile());
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function khoiphuc(Request $request)
    {
        try {
            $id=$request->get('id');
            $chuyen=\DB::table(Tables::$tb_sanpham_chuyenhangs)->where('id','=',$id)->first();
            //Trừ sản phẩm nhận
            \DB::table(Tables::$tb_sanphams)->where('id','=',$chuyen->id_sp_nhan)->decrement('SL_sp',$chuyen->sl);
            //Trả lại  sản phẩm gửi
            \DB::table(Tables::$tb_sanphams)->where('id','=',$chuyen->id_sp_gui)->increment('SL_sp',$chuyen->sl);
            //Cập nhật trạng thái
            \DB::table(Tables::$tb_sanpham_chuyenhangs)->where('id','=',$id)->update([
                'trangthai'=>State::$tt_DaKhoiPhuc
            ]);
            return response(\App\CusstomPHP\Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            Logs::log('ERROR: ' . $ex->getFile() . " LINE: " . $ex->getLine() . " FILE: " . $ex->getFile());
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }
}