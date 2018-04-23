<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\CusstomPHP\Logs;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Response;
use App\CusstomPHP\Cauhinhs;
use App\CusstomPHP\Time;
use Carbon\Carbon;

Route::any('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    } else {
        if (\App\CusstomPHP\CurrentUser::levelTT() == \App\Http\Controllers\NhanVienController::$NHANVIEN) {
            return redirect()->route('banhang');
        } else {
            return redirect()->route('get-hoadon');
        }
    }
});
Route::any('dang-nhap', 'LoginController@login')->name('login');
Route::any('dang-xuat', function () {
    Auth::logout();
    return redirect(\App\CusstomPHP\CustomURL::route('login'));
})->name('logout');


Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
    Route::any('san-pham', "SanPhamController@getView")->name('getView-sanpham');
    Route::get('get-san-pham', "SanPhamController@getSanpham")->name('get-sanpham');
    Route::post('them-san-pham', "SanPhamController@addSanpham")->name('them-sanpham');
    Route::post('sua-san-pham', "SanPhamController@editSanpham")->name('sua-sanpham');
    Route::post('xoa-san-pham', "SanPhamController@deleteSanpham")->name('xoa-sanpham');
    Route::post('check-san-pham', "SanPhamController@checkSanpham")->name('check-sanpham'); //Kiểm tra có hàng không
    Route::post('hide-san-pham', "SanPhamController@hideSanpham")->name('hide-sanpham'); //Ẩn danh sách hàng
    Route::post('show-san-pham', "SanPhamController@showSanpham")->name('show-sanpham'); //Ẩn danh sách hàng

    Route::any('khach-hang', "KhachHangController@mainKH")->name('main-khachang');
    Route::get('get-khach-hang', "KhachHangController@getKhachHang")->name('get-khachhang');
    Route::post('them-khach-hang', "KhachHangController@themKhachHang")->name('them-khachhang');
    Route::post('sua-khach-hang', "KhachHangController@suaKhachHang")->name('sua-khachhang');
    Route::post('xoa-khach-hang', "KhachHangController@xoaKhachHang")->name('xoa-khachhang');
    Route::post('loai-bo-trung', "KhachHangController@loaiboTrung")->name('loaiboTrung-khachhang');
    Route::post('sua-ngay-sinh-khach-hang', "KhachHangController@suaNgaySinhKH")->name('suaNgaySinhKH-khachhang');

    Route::any('facebook.html', "KhachHangController@facebook")->name('facebook');
    Route::any('gui-tin-nhan', 'KhachHangSentController@getSent')->name('get-sent');

    Route::any('khach-hang-voucher', "KhachHangVoucherController@mainKHVoucher")->name('main-khachangvoucher');
    Route::get('get-khach-hang-voucher', "KhachHangVoucherController@getKhachHangVoucher")->name('get-khachangvoucher');
    Route::post('them-khach-hang-voucher', "KhachHangVoucherController@themKhachHangVoucher")->name('them-khachangvoucher');
    Route::post('sua-khach-hang-voucher', "KhachHangVoucherController@suaKhachHangVoucher")->name('sua-khachangvoucher');
    Route::post('xoa-khach-hang-voucher', "KhachHangVoucherController@xoaKhachHangVoucher")->name('xoa-khachangvoucher');
    Route::post('lay-gia-tri-voucher', "KhachHangVoucherController@getgiatriVC")->name('getgiatriVC-khachangvoucher');
    Route::post('lam-sach-VC-cu', "KhachHangVoucherController@lamsachVCcu")->name('lamsachVCcu-khachangvoucher');

    Route::any('ban-hang', 'BanHangController@banhang')->name('banhang');
    Route::any('ban-hang-offline/offline.appcache', 'BanHangController@offline')->name('offline-banhang');

    Route::any('hoa-don', 'HoaDonController@getHoaDon')->name('get-hoadon');
    Route::any('them-hoa-don', 'HoaDonController@them')->name('them-hoadon');
    Route::any('xoa-hoa-don', 'HoaDonController@xoa')->name('xoa-hoadon');
    Route::any('sua-hoa-don', 'HoaDonController@sua')->name('sua-hoadon');
    Route::any('getsp-hoa-don', 'HoaDonController@getsp')->name('getsp-hoadon');
    Route::any('cap-nhat-hang-hoa-don', 'HoaDonController@capnhathang')->name('capnhathang-hoadon');
    Route::any('hang-hoa-don', 'HoaDonController@hanghoa')->name('hanghoa-hoadon');
    Route::any('tong-quan-hoa-don', 'HoaDonController@tongquan')->name('tongquan-hoadon');

    Route::get('cau-hinh', 'CauhinhController@getCauhinh')->name('get-cauhinh');
    Route::post('luu-cau-hinh', 'CauhinhController@luuCauhinh')->name('luu-cauhinh');

    Route::get('chi-nhanh', 'ChiNhanhController@getChiNhanh')->name('get-chinhanh');
    Route::any('them-chi-nhanh', 'ChiNhanhController@themChiNhanh')->name('them-chinhanh');
    Route::any('sua-chi-nhanh', 'ChiNhanhController@suaChiNhanh')->name('sua-chinhanh');
    Route::any('xoa-chi-nhanh', 'ChiNhanhController@xoaChiNhanh')->name('xoa-chinhanh');

    Route::get('nhan-vien', 'NhanVienController@getNhanVien')->name('get-nhanvien');
    Route::any('them-nhan-vien', 'NhanVienController@themNhanVien')->name('them-nhanvien');
    Route::any('sua-nhan-vien', 'NhanVienController@suaNhanVien')->name('sua-nhanvien');
    Route::any('xoa-nhan-vien', 'NhanVienController@xoaNhanVien')->name('xoa-nhanvien');

    Route::any('chuyen-hang', 'SanPhamChuyenHangController@get')->name('get-chuyenhang');
    Route::any('xuat-kho', 'SanPhamChuyenHangController@getxuatkho')->name('getxuatkho-chuyenhang');
    Route::any('lich-su-chuyen-hang', 'SanPhamChuyenHangController@getLichsu')->name('getLichsu-chuyenhang');
    Route::any('chuyen-chuyen-hang', 'SanPhamChuyenHangController@chuyen')->name('chuyen-chuyenhang');
    Route::any('khoi-phuc-chuyen-hang', 'SanPhamChuyenHangController@khoiphuc')->name('khoiphuc-chuyenhang');

    Route::any('doi-gia', 'SanPhamDoiGiaController@get')->name('get-doigia');
    Route::any('set-doi-gia', 'SanPhamDoiGiaController@set')->name('set-doigia');

    Route::any('dat-hang', 'DatHangController@getDatHang')->name('get-dathang');
    Route::any('them-dat-hang', 'DatHangController@them')->name('them-dathang');
    Route::any('xoa-dat-hang', 'DatHangController@xoa')->name('xoa-dathang');
    Route::any('sua-dat-hang', 'DatHangController@sua')->name('sua-dathang');
    Route::any('getsp-dat-hang', 'DatHangController@getsp')->name('getsp-dathang');

    Route::any('lich-su-nhap-hang', 'SanPhamNhapHangController@getLichSu')->name('getLichSu-nhaphang');
    Route::any('nhap-hang', 'SanPhamNhapHangController@get')->name('get-nhaphang');
    Route::any('nhap-hang-nhap-kho', 'SanPhamNhapHangController@getNhapKho')->name('nhapkho-nhaphang');
    Route::any('delete-nhap-hang', 'SanPhamNhapHangController@delete')->name('delete-nhaphang');

    Route::any('ajax-all', 'AjaxController@getAll')->name('all-ajax');
    
    Route::any('ajax-all-khach-hang', 'AjaxController@getAllKhanhHangForBanHang')->name('get-all-khach-hang-ajax');
    
    Route::any('ajax-all-sp-by-daily', 'AjaxController@getAllSanPhamByDaily')->name('ajax-all-sp-by-daily');
    Route::any('ajax-all-hoadon-by-daily', 'HoaDonController@getAllByDaily')->name('ajax-all-hoadon-by-daily');
    Route::any('ajax-Column', 'AjaxController@getbyColumn')->name('column-ajax');
    Route::any('ajax-san-pham-KHO', 'AjaxController@getsanphamKHO')->name('getsanphamKHO-ajax');
    Route::any('ajax-hoa-don-today', 'AjaxController@gethoadonTODAY')->name('gethoadonTODAY-ajax');
    Route::any('ajax-nhom-lich-su-chuyen', 'AjaxController@nhomlichsuchuyenhan')->name('nhomlichsuchuyenhan-ajax');
    Route::any('ajax-nhom-lich-su-nhap', 'AjaxController@nhomlichsunhap')->name('nhomlichsunhap-ajax');
    Route::any('ajax-san-pham-an', 'AjaxController@getSanphamAN')->name('sanphamAN-ajax');

    Route::any('thong-ke-san-pham-ban-chay', 'ThongkeController@sanpham')->name('sanpham-banchay-thongke');
    Route::any('thong-ke-san-pham-ban-cham', 'ThongkeController@sanphambancham')->name('sanpham-bancham-thongke');
    Route::any('thong-ke-ban-hang', 'ThongkeController@banhang')->name('banhang-thongke');
    Route::any('thong-ke-khach-hang', 'ThongkeController@khachhang')->name('khachhang-thongke');

    Route::any('trang-chu', "TrangChuController@getTrangChu")->name('get-trangchu');
    Route::any('sao-luu', "SaoLuuController@saoluu")->name('get-saoluu');
});

