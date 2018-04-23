<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 28/03/2017
 * Time: 13:27
 */
namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Logs;
use App\CusstomPHP\Response;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class HoaDonController extends Controller
{

    public function getHoaDon()
    {
        return view('page.hoadon.hoadon', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
            'khachhangs' => \DB::table(Tables::$tb_khachhangs)->get(),
        ]);
    }

    public function hanghoa()
    {
        return view('page.hoadon.hanghoaHD', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
            'khachhangs' => \DB::table(Tables::$tb_khachhangs)->get(),
        ]);
    }

    public function tongquan()
    {
        return view('page.hoadon.tongquan', [
            'chinhanhs' => \DB::table(Tables::$tb_chinhanhs)->get(),
            'khachhangs' => \DB::table(Tables::$tb_khachhangs)->get(),
        ]);
    }

    public function them(Request $request)
    {
        $columns = \App\CusstomPHP\Tables::getColumns(\App\CusstomPHP\Tables::$tb_hoadons);
        $data = [];
        foreach ($columns as $item) {
            $data[$item] = $request->get($item);
        }

        $this->truSLHH($request->get('sanpham_muas'), $request->get('daily_hd'));

        //đổi trạng thái
        if ($data['tongtienKhachTra_hd'] != $data['tongtienKM_hd']) {
            $data['trangthai'] = State::$tt_Nolai;
        }
        //Loại bỏ mã voucher khách hàng
        if (intval($data['tienVC_hd']) > 0) {
            $code = $request->get('code');
            $donvi = Tables::getValue('donvi_diem', \App\CusstomPHP\Tables::$tb_khachhang_cauhinhs);
            KhachHangVoucherController::loaiBoMaKH($code);
            KhachHangVoucherController::giamdiemKH($data['id_kh'], intval($data['tienVC_hd']) / intval($donvi));
        }

        unset($data['id']);
        $data['ngaytao'] = Time::now();
        $data['ngaysua'] = Time::now();

        if (\DB::table(Tables::$tb_hoadons)->insert($data)) {
            //Tạo voucher cho khách hàng
            $giatriHD = $data['tongtienKM_hd'];
            $donvi = Tables::getValue('donvi_diem', \App\CusstomPHP\Tables::$tb_khachhang_cauhinhs);
            $giatriVC = floatval($giatriHD) / floatval($donvi) / 100 * 5;
            $giatriVC = intval($giatriVC);
            $thoigianhethan = Time::homsau24h();
            $code = KhachHangVoucherController::taoVoucher($giatriVC, $thoigianhethan);
            if (HoaDonController::GuiHoaDOnveFB($data['id_kh'], $data['ma_hd'], $code)) {
                $code = '"Đã nạp tự động!"';
            };
            return response('{"success":true, "code":' . $code . '}', 200, Response::$jsonHeader);
        } else {
            return response(Response::$error, 200, Response::$jsonHeader);
        }
    }


    public static function GuiHoaDOnveFB($id_KH, $maHD, $code)
    {
        try {
            $kh = \DB::table(Tables::$tb_khachhangs)->where('id', '=', $id_KH)->first();
            if ($kh->id_fb != '') {
                FacebookController::guiTinNhan($kh->id_fb,
                    "Quý khách vừa thanh toán hóa đơn: " . $maHD . "\n" .
                    FacebookController::naptienHD($kh->id_fb, $code)
                );
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function sua(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_hoadons);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['ngaysua'] = Time::now();
            if (\DB::table(Tables::$tb_hoadons)->where('id', '=', $data['id'])->update($data)) {
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
            if (\DB::table(Tables::$tb_hoadons)->where('id', '=', $request->get('id'))->delete()) {
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
            $data = \DB::table(Tables::$tb_hoadons)->where('id', '=', $request->get('id'))->first(['sanpham_muas'])->sanpham_muas;
            return response($data, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }

    public function capnhathang(Request $request)
    {
        try {
            $danhsachsanpham = $request->get('sanpham_muas');
            $data = \DB::table(Tables::$tb_hoadons)->where('id', '=', $request->get('id'))->first();

            $this->TinhtoanSL($danhsachsanpham, $data->sanpham_muas, $data->daily_hd);

            \DB::table(Tables::$tb_hoadons)->where('id', '=', $request->get('id'))->update([
                'sanpham_muas' => $danhsachsanpham,
                'ngaysua' => Time::now()
            ]);
            return response(Response::$succ, 200, \App\CusstomPHP\Response::$jsonHeader);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . " LINE: " . $ex->getLine());
            return response(\App\CusstomPHP\Response::$error, 200, \App\CusstomPHP\Response::$jsonHeader);
        }
    }


    public function TinhtoanSL($json_ban, $json_ban_cu, $daily)
    {
        $data = json_decode($json_ban);
        $data_cu = json_decode($json_ban_cu);
        //Khôi phục lại các hàng bán cũ
        foreach ($data_cu as $item) {
            //Lấy sp
            $sp = \DB::table(Tables::$tb_sanphams)->where('id', '=', $item->id)->first();
            $SL_sp = $sp->SL_sp;
            $SL_MUA = $item->SL_MUA;
            \DB::table(Tables::$tb_sanphams)->where('id', '=', $item->id)->update(['SL_sp' => ($SL_sp + $SL_MUA)]);
        }
        //Lưu lại data mới
        foreach ($data as $item) {
            //Lấy sp
            $sp = \DB::table(Tables::$tb_sanphams)->where('id', '=', $item->id)->first();
            $SL_sp = $sp->SL_sp;
            $SL_MUA = $item->SL_MUA;
            \DB::table(Tables::$tb_sanphams)->where('id', '=', $item->id)->update(['SL_sp' => ($SL_sp - $SL_MUA)]);
        }
    }

    public function truSLHH($json_ban, $daily)
    {
        $data = json_decode($json_ban);
        foreach ($data as $item) {
            $id = $item->id;
            $SL_sp = $item->SL_sp;
            $SL_MUA = $item->SL_MUA;
            \DB::table(Tables::$tb_sanphams)->where([
                ['id', '=', $id],
                ['daily_sp', '=', $daily]
            ])->update(['SL_sp' => ($SL_sp - $SL_MUA)]);
        }
    }
}