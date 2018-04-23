<?php
namespace App\Http\Controllers;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Logs;
use App\CusstomPHP\Response;
use App\CusstomPHP\Cauhinhs;
use App\CusstomPHP\SentHTTP;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class FacebookController extends Controller
{
    public static $token = 'mELtlMAHYqR0BvgEiMq8zVekYUK3OJMbtyrdNPTrQB9ndV0fM7lWTFZbM4MZvD';
    public static $app_id = '58f5829ee4b0cd8168ea9a74';

    public static $block_id_guitin = '58f80733e4b0cd816ea9e1d8';
    public static $block_id_guihinh = '58f8077ce4b0cd816eaa3002';
    public static $block_id_guiYC_sdt = '58f809e3e4b0cd816eacd733';
    public static $block_id_guiSinhnhat = '5919b3e2e4b04ca3498b211d';

    public static $id_quantri = '1094636433975114';


    public function tinhanDefault($id, $noidung)
    {
        /*
        * # code-> lấy thông tin voucher
        * #sdt sdt -> Cập nhật thông tin số điện thoại
        * #kiemtra -> kiểm tra số dư tích lũy
        * #NAP code
        * */
        if (substr(strtoupper($noidung), 0, 3) == 'NAP') {
            return $this->naptien($id, substr($noidung, 4, strlen($noidung) - 4));
        }
        if (substr(strtoupper($noidung), 0, 3) == 'TIM') {
            return $this->xemtinhtranghang($id, substr($noidung, 4, strlen($noidung) - 4));
        }
        if (substr(strtoupper($noidung), 0, 3) == 'SDT') {
            return $this->capnhatsdt($id, substr($noidung, 4, strlen($noidung) - 4));
        }
        if (substr(strtoupper($noidung), 0, 7) == 'KIEMTRA') {
            return $this->kiemtra($id);
        }
        if (substr(strtoupper($noidung), 0, 6) == 'BATDAU') {
            $this->batdau($id);
            return $this->getJsonText("Chào mừng quý khách hàng đến với hệ thống chăm sóc khách hàng của công ty thời trang Cẩm Tú\n\nChúng tôi rất hân hạnh được phục vụ quý khách hàng.");

        }
        if (substr(strtoupper($noidung), 0, 9) == 'THANHTOAN') {
            return $this->laymathanhtoan($id);
        }
        if (substr(strtoupper($noidung), 0, 2) == 'TL') {
            $id_kh = substr($noidung, 3, 16);
            $noidungtl = substr($noidung, 20, strlen($noidung) - 19);
            $noidungtl = str_replace('+', ' ', $noidungtl);
            FacebookController::guiTinNhan($id_kh, $noidungtl);
            return $this->getJsonText('Đã trả lời ' . $id_kh);
        }
        //Gửi tin nhắn tới quản trị
        $noidung = str_replace('+', ' ', $noidung);
        FacebookController::guiTinNhan(FacebookController::$id_quantri, "Tin nhắn mới: \n" . $noidung . "\n\n" . "Trả lời nhanh: TL " . $id . " [noidung]");
        return $this->getJsonText('');
    }

    public function capnhatsdt($id, $sdt)
    {
        try {
            if (strlen($sdt) < 10) {
                return response($this->getJsonText("Số điện thoại '" . $sdt . "' quý khách nhập không hợp lệ vui lòng thử lại!"), 200, Response::$jsonHeader);
            }
            //Nếu đã đăng kí mà chưa có facebook, giờ cập nhật fb bằng sdt
            if (\DB::table(Tables::$tb_khachhangs)->where('sdt', '=', $sdt)->exists()) {
                //Remove khách hàng có fb, chưa sdt=id
                \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                    'id_fb' => ''
                ]);
                \DB::table(Tables::$tb_khachhangs)->where('sdt', '=', $sdt)->update([
                    'id_fb' => $id
                ]);
            } else {
                //Nếu chưa có sđt mà đã có fb
                \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                    'sdt' => $sdt
                ]);
            }
            //Thành công
            return response($this->getJsonText("Số điện thoại cập nhật thành công!"), 200, Response::$jsonHeader);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }

        return response(Response::$error, 500, Response::$jsonHeader);
    }

    public function batdau($id)
    {
        try {
            //Kiểm tra khách hàng đẫ tồn tại chưa, nếu chưa thì thêm vào csdl
            if (!\DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->exists()) {
                $khachang = json_decode(SentHTTP::SentGET(SentHTTP::$urlFB . $id . "?access_token=" . Tables::getValue('token', Tables::$tb_khachhang_cauhinhs)));
                \DB::table(Tables::$tb_khachhangs)->insert([
                    'hoten' => $khachang->first_name . ' ' . $khachang->last_name,
                    'anh' => $khachang->profile_pic,
                    'gioitinh' => $khachang->gender,
                    'ngaytao' => Time::now(),
                    'ngaysua' => Time::now(),
                    'diem' => 0,
                    'id_fb' => $id,
                    'trangthai' => State::$tt_Kichhoat,
                ]);
            };
            //Thành công
            return response($this->getJsonText(""), 200, Response::$jsonHeader);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }

        return response(Response::$error, 500, Response::$jsonHeader);
    }

    public function naptien($id, $code)
    {
        $data = '';
        try {
            if (\DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->exists()) {
                $vc = \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->first();
                $trangthai = $vc->trangthai;
                $hethan = $vc->hethan;
                $now = Carbon::now("Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
                $now = Carbon::createFromFormat('H:i d/m/Y', $now, "Asia/Ho_Chi_Minh");
                $hethan = Carbon::createFromFormat('H:i d/m/Y', $hethan, "Asia/Ho_Chi_Minh");
                if ($trangthai == State::$tt_HoatDong) {
                    if ($now->lte($hethan)) {
                        //vd Nap 634
                        $value = \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->first()->value;
                        $diemKH = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first()->diem;
                        $luotKH = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first()->luot;
                        $ngaysinh_KH = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first()->ngaysinh;
                        //x2 giá trị voucher nhân tháng sinh nhật khách hàng
                        $str_Sinhnhat="";
                        try{
                            if($ngaysinh_KH != ''){
                                if($ngaysinh_KH != '01/01/2000'){
                                    $sinhnhat_KH=Carbon::createFromFormat('d/m/Y', $ngaysinh_KH, "Asia/Ho_Chi_Minh");
                                    if($sinhnhat_KH->month==$now->month){
                                        $value=intval(intval($value)/intval(Cauhinhs::getCauHinh('phamtramtich'))*intval(Cauhinhs::getCauHinh('phamtramtichSN')));
                                        $str_Sinhnhat="\n\n🎉  🎈 😊 x2 giá trị tích điểm trong tháng sinh nhật khách hàng 😊 🎈 🎉";
                                    }
                                }
                            }
                        }catch(\Exception $i){}
                        //Cập nhật vào khách hàng
                        $daily_KH = \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->first()->daily;
                        if($daily_KH!=''){
                            \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                                'diem' => ($diemKH + $value),
                                'luot' => ($luotKH + 1),
                                'chinhanh'=>$daily_KH
                            ]);
                        }else{
                            \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                                'diem' => ($diemKH + $value),
                                'luot' => ($luotKH + 1)
                            ]);
                        }
                        //Cập nhật code
                        \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->update([
                            'trangthai' => State::$tt_DaNap
                        ]);
                        //Trả về
                        $data = $this->getJsonText(":D :D :D :D :D \n➡Chúc mừng bạn đã tích thành công " . $value . " điểm!\n\n➡Bạn đã tích được tổng: " . ($diemKH + $value) .
                            " điểm. \n➡Quy đổi sang tiền tổng bạn có: " . number_format((($diemKH + $value) * Tables::getValue('donvi_diem', Tables::$tb_khachhang_cauhinhs))) .
                            " VNĐ \n\n➡Hãy tiếp tục mua sắm để tích thêm tiền vào tài khoản nhé. \n\nCảm ơn quý khách hàng! ".$str_Sinhnhat
                        );
                    } else {
                        $data = $this->getJsonText(":( Rất tiếc mã nạp '" . $code . "' của quý khách đã hết hạn lúc: " . $vc->hethan);
                    }
                } else {
                    $data = $this->getJsonText(":( Rất tiếc mã nạp '" . $code . "' của quý khách không hợp lệ.");
                }
            } else {
                $data = $this->getJsonText(":( Rất tiếc mã nạp '" . $code . "' của quý khách không hợp lệ.");
            }
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
        return response($data, 200, Response::$jsonHeader);
    }


    public static function naptienHD($id, $code)
    {
        try {
            if (\DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->exists()) {
                $vc = \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->first();
                $trangthai = $vc->trangthai;
                $hethan = $vc->hethan;
                $now = Carbon::now("Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
                $now = Carbon::createFromFormat('H:i d/m/Y', $now, "Asia/Ho_Chi_Minh");
                $hethan = Carbon::createFromFormat('H:i d/m/Y', $hethan, "Asia/Ho_Chi_Minh");
                if ($trangthai == State::$tt_HoatDong) {
                    if ($now->lte($hethan)) {
                        //vd Nap 634
                        $value = \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->first()->value;
                        $diemKH = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first()->diem;
                        $luotKH = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first()->luot;
                        $ngaysinh_KH = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first()->ngaysinh;
                        //x2 giá trị voucher nhân tháng sinh nhật khách hàng
                        $str_Sinhnhat="";
                        try{
                            if($ngaysinh_KH != ''){
                                if($ngaysinh_KH != '01/01/2000'){
                                    $sinhnhat_KH=Carbon::createFromFormat('d/m/Y', $ngaysinh_KH, "Asia/Ho_Chi_Minh");
                                    if($sinhnhat_KH->month==$now->month){
                                        $value=intval(intval($value)/intval(Cauhinhs::getCauHinh('phamtramtich'))*intval(Cauhinhs::getCauHinh('phamtramtichSN')));
                                        $str_Sinhnhat="\n\n🎉  🎈 😊 x2 giá trị tích điểm trong tháng sinh nhật khách hàng 😊 🎈 🎉";
                                    }
                                }
                            }
                        }catch(\Exception $i){}
                        //Cập nhật vào khách hàng
                        $daily_KH = \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->first()->daily;
                        if($daily_KH!=''){
                            \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                                'diem' => ($diemKH + $value),
                                'luot' => ($luotKH + 1),
                                'chinhanh'=>$daily_KH
                            ]);
                        }else{
                            \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                                'diem' => ($diemKH + $value),
                                'luot' => ($luotKH + 1)
                            ]);
                        }
                        //Cập nhật code
                        \DB::table(Tables::$tb_khachhang_vouchers)->where('code', '=', $code)->update([
                            'trangthai' => State::$tt_DaNap
                        ]);
                        //Trả về
                        return ":D :D :D :D :D \n➡Chúc mừng quý khách đã tích thành công " . $value . " điểm!\n\n➡Bạn đã tích được tổng: " . ($diemKH + $value) .
                            " điểm. \n➡Quy đổi sang tiền tổng quý khách có: " . number_format((($diemKH + $value) * Tables::getValue('donvi_diem', Tables::$tb_khachhang_cauhinhs))) .
                            " VNĐ \n\n➡Hãy tiếp tục mua sắm để tích thêm tiền vào tài khoản nhé. \n\nCảm ơn quý khách hàng!".$str_Sinhnhat;
                    } else {
                    }
                } else {
                }
            } else {
            }
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
        return '';
    }

    public static function yeucaunapsodienthoai($id)
    {
        try {
            //Logs::log($id);
            if (\DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->exists()) {
                $khachhang = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first();
                if (strlen($khachhang->sdt) < 10) {
                    $url = 'https://api.chatfuel.com/bots/' . FacebookController::$app_id . '/users/' . $id . '/send?chatfuel_token=' . FacebookController::$token . '&chatfuel_block_id=' . FacebookController::$block_id_guiYC_sdt;
                    $trave = SentHTTP::SentPOST($url);
                }
            }
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
    }


    public function kiemtra($id)
    {
        $data = '';
        try {
            $khachhang = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first();
            $data = $this->getJsonText(
                "Tên khách hàng: " . $khachhang->hoten .
                "\nSố điện thoại: " . $khachhang->sdt .
                "\nĐiểm thưởng: " . $khachhang->diem . ' điểm' .
                "\nTiền thưởng: " . number_format($khachhang->diem * Tables::getValue('donvi_diem', Tables::$tb_khachhang_cauhinhs)) . ' VNĐ' .
                "\nNgày tạo: " . $khachhang->ngaytao);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
        return response($data, 200, Response::$jsonHeader);
    }

    //Lấy mã thanh toán
    public function laymathanhtoan($id)
    {
        $data = '';
        try {
            $khachhang = \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->first();
            $homqua = Carbon::yesterday("Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
            $homqua = Carbon::createFromFormat('H:i d/m/Y', $homqua, "Asia/Ho_Chi_Minh");
            $ngaytao = Carbon::createFromFormat('H:i d/m/Y', $khachhang->ngaytao, "Asia/Ho_Chi_Minh");

            if ($ngaytao->lte($homqua)) {
                if (intval($khachhang->diem) >= 20) {
                    $thoigianhethan = Time::hom30day();
                    $code = KhachHangVoucherController::taoVoucherKH($khachhang->diem, $thoigianhethan);
                    $giatri = intval(floatval($khachhang->diem) * floatval(Tables::getValue('donvi_diem', Tables::$tb_khachhang_cauhinhs)));
                    $data = $this->getJsonText(
                        'Mã của quý khách: ' . $code . "\n" .
                        'Giá trị mã: ' . number_format($giatri) . "đ\n" .
                        'Hạn dùng: ' . $thoigianhethan . "\n"
                    );
                    \DB::table(Tables::$tb_khachhangs)->where('id_fb', '=', $id)->update([
                        'diem' => 0,
                        'code' => $code
                    ]);
                } else {
                    if ($khachhang->code != '') {
                        $data = $this->getJsonText("Quý khách có mã: " . $khachhang->code . " chưa sử dụng. Hãy sử dụng nó!");
                    } else {
                        $data = $this->getJsonText("Điểm thưởng của quý khách chưa đủ để thực hiện thao tác này! Quý khách vui lòng tích thêm điểm thưởng và thử lại sau.");
                    }
                }

            } else {
                $data = $this->getJsonText("Thời gian khởi tạo của quý khách chưa được 24h nên chưa thể thực hiện thao tác này. Cảm ơn quý khách hàng!");
            }

        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
        return response($data, 200, Response::$jsonHeader);
    }

    public function xemtinhtranghang($id, $ma_sp)
    {
        $data = '';
        try {
            //Logs::log($ma_sp);
            $sanphams = \DB::table(Tables::$tb_sanphams)->where([
                ['ma_sp', 'LIKE', '%' . $ma_sp . '%'],
                ['SL_sp', '>', 0]
            ])->limit(10)->get();
            foreach ($sanphams as $item) {
                $noidungTL = "Mã hàng: " . $item->ma_sp . "\nGiá: " . number_format($item->gia_sp) . "\nGiá KM: " . number_format($item->giaKM_sp);
                $chinhanh = \DB::table(Tables::$tb_chinhanhs)->get();
                $daily_conhang = '';
                foreach ($chinhanh as $item2) {
                    if (\DB::table(Tables::$tb_sanphams)->where([
                        ['daily_sp', '=', $item2->ma_cn],
                        ['ma_sp', '=', $item->ma_sp],
                        ['SL_sp', '>', 0]
                    ])->exists()
                    ) {
                        $daily_conhang .= '- ' . $item2->diachi_cn . "\n";
                    }
                }
                $noidungTL .= "\nĐại lý còn hàng\n" . $daily_conhang;
                FacebookController::guiTinNhan($id, $noidungTL);
                //FacebookController::guiYEUCAUanh($id, 'http://garlovy.hoangdai.net/public/images/sanphams/vay.jpg');
            }
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
        return response($this->getJsonText('...'), 200, Response::$jsonHeader);
    }

    /////////////////////////////////////////Gửi text chatfuel
    public function getJsonText($noidung)
    {
        $data = array(
            'text' => $noidung
        );
        return '{"messages": [' . json_encode($data) . ']}';
    }


    public static function guiTinNhan($id_fb, $noidung)
    {
        try {
            $noidung = urlencode($noidung);
            $url = 'https://api.chatfuel.com/bots/' . FacebookController::$app_id . '/users/' . $id_fb . '/send?chatfuel_token=' . FacebookController::$token . '&chatfuel_block_id=' . FacebookController::$block_id_guitin . '&noidung=' . $noidung;
            $trave = SentHTTP::SentPOST($url);
            sleep(2);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
    }

    public static function guiBlock($id_fb, $block)
    {
        try {
            $url = 'https://api.chatfuel.com/bots/' . FacebookController::$app_id . '/users/' . $id_fb . '/send?chatfuel_token=' . FacebookController::$token . '&chatfuel_block_id=' . $block;
            $trave = SentHTTP::SentPOST($url);
            sleep(2);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
    }

    public static function guiYEUCAUanh($id_fb, $noidung)
    {
        try {
            $noidung = urlencode($noidung);
            $url = 'https://api.chatfuel.com/bots/' . FacebookController::$app_id . '/users/' . $id_fb . '/send?chatfuel_token=' . FacebookController::$token . '&chatfuel_block_id=' . FacebookController::$block_id_guihinh . '&link_anh=' . $noidung;
            $trave = SentHTTP::SentPOST($url);
            Logs::log($trave);
            Logs::log($url);
            sleep(2);
        } catch (\Exception $ex) {
            Logs::log($ex->getFile() . " ERROR: " . $ex->getMessage() . "LINE: " . $ex->getLine());
        }
    }

    public function guianh(Request $request)
    {
        $link_anh = $request->get('link_anh');
        return '{"messages": [{ "attachment": {"type": "image","payload": {
          "url": "' . $link_anh . '"
          }}}]}';
    }

}