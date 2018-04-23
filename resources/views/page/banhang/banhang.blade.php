@extends('page.master')

{{--@section('offline') manifest="{!! \App\CusstomPHP\CustomURL::route('offline-banhang') !!}" @stop--}}

@section('title') Bán hàng @stop
@section('style'){!! \App\CusstomPHP\AssetFile::css('flat/green.css') !!}@stop

@section('content')
    <div id="trang_banhang" class=" an">
        <div class="x_panel">
            <div class="x_title">
                <h2 class="an hide">{!! $nhanvien->name !!}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Xem lại hóa đơn vừa in">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".modal-xemhoadontruoc">
                            <i class="fa fa-backward"></i>
                            Hóa đơn trước
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="In hóa đơn tất cả các hàng đã bán trong ngày hôm nay">
                        <button id="btn_inhoadonngay" class="btn btn-primary btn-sm">
                            <i class="fa fa-database"></i>
                            In hóa đơn ngày
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Nhập % khuyến mãi cho khách hàng">
                        <button id="btn_khuyenmai" class="btn btn-primary btn-sm">
                            <i class="fa fa-shekel"></i>
                            Khuyến mãi
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Nhập mã giảm giá cho khách hàng">
                        <button id="btn_magiamgia" class="btn btn-primary btn-sm">
                            <i class="fa fa-download"></i>
                            Mã giảm giá
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Kiểm tra hàng tồn kho">
                        <button id="btn_hienthihang"
                                onclick="$('#input_hienthihang').val('');hienthihangxem.html('');setTimeout(function() {$('#input_hienthihang').focus();},100);"
                                class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target=".modal-xemhang">
                            <i class="fa fa-eye"></i>
                            Xem hàng (F8)
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Xóa tất cả hàng đang chọn và làm lại từ đầu">
                        <button onclick="khoiphuc();" class="btn btn-primary btn-sm">
                            <i class="fa fa-recycle"></i>
                            Khôi phục (F7)
                        </button>
                    </li>
                    <li class="dropdown">
                        <button onclick="$('#masp').focus();" class="btn btn-primary btn-sm">
                            <i class="fa fa-laptop"></i>
                            Bán hàng (F6)
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Lưu các hóa đơn chưa chưa lưu (do lỗi mạng) lên hệ thống">
                        <button disabled id="dongbohoadon" class="btn btn-primary btn-sm">
                            <i class="fa fa-cloud-upload"></i>
                            Đồng bộ hóa đơn
                        </button>
                    </li>
                    <li class="dropdown" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Nạp lại danh mục hàng trên hệ thống">
                        <button onclick="khoiphuc();taiDulieu(false);" class="btn btn-primary btn-sm">
                            <i class="fa fa-refresh"></i>
                            Tải lại <span id="trangthaitai"></span>
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="">
                    <div class="col-sm-9 col-md-9">
                        <div class="clearfix ctm-123">
                            <h4 class="bh-123">Bán hàng</h4>
                            <input autofocus list="list_masp" id="masp"
                                   class="ip-bh-123 form-control input-uppercase key_nhap"
                                   placeholder="Nhập mã sản phẩm...">
                        </div>
                        <div class="bang-banhang">
                            <table class="table table-bordered jambo_table">
                                <thead>
                                <tr>
                                    <th>TT</th>
                                    <th>Mã hàng</th>
                                    <th>Tên hàng</th>
                                    <th>Đơn giá</th>
                                    <th>Giá KM</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="bang_hang_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 bg-success" style="padding: 0;">
                        <div class="tt-124">Thông tin khách hàng</div>
                        <div style="padding: 10px 15px 10px 15px;">
                            <datalist id="list_masp"></datalist>
                            <datalist id="list_kh"></datalist>
                            <input type="hidden" id="id_kh" class="ip-x-124 form-control input-sm key_nhap">
                            <label>Số điện thoại khách hàng:</label>
                            <input list="list_kh" id="sdt" type="text" class="ip-x-124 form-control input-sm key_nhap">
                            <label>Họ tên khách hàng:</label>
                            <input id="hoten" type="text" class="ip-x-124 form-control input-sm key_nhap">
                            <label>Giới tính khách hàng:</label>
                            <select id="gioitinh" class="ip-x-124 form-control input-sm key_nhap">
                                <option value="">Không rõ</option>
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                            </select>
                            <label>Địa chỉ khách hàng:</label>
                            <input id="diachi" type="text"
                                   class="ip-x-124 form-control input-sm">
                            <label>Ngày sinh khách hàng:</label>
                            <input id="ngaysinh" type="text" value="01/01/2000" class="ip-x-124 form-control input-sm">
                            <label>Ghi chú:</label>
                            <textarea id="ghichu" class="form-control"></textarea>
                            <label id="CD_khachno">
                                <input id="khachno" class="nutcheck" type="checkbox"> Khách có nợ lại tiền hàng</label>
                            <label id="CD_dathang">
                                <input id="dathang" class="nutcheck" type="checkbox"> Chế độ khách đặt hàng
                            </label>
                            <label id="CD_donhangoline">
                                <input id="donhangonline" class="nutcheck" type="checkbox">  Đơn hàng online
                            </label>
                            <hr style="margin-top: 7px;margin-bottom: 7px;">
                            <button style="height: 50px;
    font-size: 17px;
    margin-left: -15px;
    margin-right: -15px;
    width: calc(100% + 30px);
    border-radius: 0;" id="luuHD" class="btn btn-primary btn-block">
                                <i class="fa fa-print"></i>
                                Lưu hóa đơn (F9)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--Modal--}}
    <div class="modal modal-xemhang" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Xem hàng trong kho</h4>
                </div>
                <div class="modal-body">
                    <input id="input_hienthihang" list="list_masp" class="form-control" placeholder="Nhập mã hàng...">
                    <hr>
                    <ul id="hienthihangxem" class="text-bold">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-khachno" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Nhập tiền khách trả</h4>
                </div>
                <div class="modal-body">
                    <input id="input_tienkhachno" class="form-control tien-input" placeholder="Nhập tiền khách trả..">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button id="btn_luutienkhachno" type="button" class="btn btn-primary" data-dismiss="modal">Lưu lại
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-dathang" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Thông tin đặt hàng</h4>
                </div>
                <div class="modal-body">
                    <label>Nhập tiền khách đặt:</label>
                    <input id="input_tienkhachdat" class="form-control tien-input">
                    <label>Ngày khách nhận hàng:</label>
                    <input id="input_ngaynhanhang" type="date" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button id="btn_luudathang" type="button" class="btn btn-primary" data-dismiss="modal">Lưu lại
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-xemhoadontruoc" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Xem hóa đơn trước</h4>
                </div>
                <div class="modal-body">
                    {{--/Hóa đơn--}}
                    <div style="width: 300px;padding: 5px;margin: 0 auto;">
                        <div id="hoadon">
                            {!! \App\CusstomPHP\Cauhinhs::getCauHinh('hoadon_template') !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="$('#hoadon').print();" type="button" class="btn btn-primary">In lại hóa đơn này
                    </button>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')
    {!! \App\CusstomPHP\AssetFile::js('Print/jQuery.print.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('hotkey/hotkeys.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('icheck/icheck.min.js') !!}

    <script>
        var khachhangs = [];
        var sanphams = [];

        var kh_dangchon = null;

        //Chế độ
        var CD_khachno = false;
        var CD_dathang = true;
        var CD_suagiaKM = false;
        //Khai báo domHTML
        var btn_magiamgia = $('#btn_magiamgia');
        var o_nhapma = $('#masp');
        var table = $('#bang_hang_body');
        var trangbanhang = $('#trang_banhang');
        var btn_inhoadonngay = $('#btn_inhoadonngay');
        var btn_khuyenmai = $('#btn_khuyenmai');
        //Thẻ bài
        var token = '{!! csrf_token() !!}';
        //Biến đánh dấu
        var DD_giamgia = false; //Khi sử dụng voucher
        var DD_khuyenmai = false; //Khi sử dụng voucher

        //Biến giá trị
        var GT_giamgia = 0; //Khi sử dụng voucher
        var GT_code = '';
        var GT_khuyenmai = 0;

        var matichdiem = '';
        var daily = "{!! $nhanvien->daily !!}";
        var diachidaily_hd = "{!! $daily->diachi_cn !!}";
        var sdtdaily_hd = "{!! $daily->sdt_cn !!}";

        var kh_tontai = false;
        var mahd = '';
        var sp_dachon = {};
        var sp_dachon_sl = 0;

        var offline = false;//Lưu giá trị offline
        var khachno = false;
        var tienkhachtra = 0;

        var dathang = false;
        var tien_dathang = 0;
        var ngay_dathang = 0;

        var template_hoadon;

        var dulieuHD;

        $(document).ready(function () {
            localStorage.clear();
            hienthi_btn_dongbo();
            $('#menu_toggle').click();
            taiDulieu(true);
            template_hoadon = $('#hoadon').html();
            if (CD_khachno) {
                $('#CD_khachno').show();
            } else {
                $('#CD_khachno').hide();
            }
            if (CD_dathang) {
                $('#CD_dathang').show();
            } else {
                $('#CD_dathang').hide();
            }
        });

        //Tải dữ liệu trên mạng về
        function taiDulieu(an) {
            if (an) {
                trangbanhang.hide();
            }
            //NProgress.start();
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('ajax-all-sp-by-daily') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_sanphams !!}',
                    _token: token
                },
                dataType: 'json',
                success: function (result) {
                    sanphams = result;
                    NProgress.done();
                    trangbanhang.show();
                    //Load lên menu
                    $.ajax({
                        method: 'GET',
                        url: '{!! \App\CusstomPHP\CustomURL::route('get-all-khach-hang-ajax') !!}',
                        data: {
                            table: '{!! \App\CusstomPHP\Tables::$tb_khachhangs !!}',
                            _token: token
                        },
                        dataType: 'json',
                        success: function (result) {
                            khachhangs = result;
                            //Load lên menu
                            loadLenMenu();
                        },
                        error: function () {
                        },
                        progress: function (e) {
                            //make sure we can compute the length
                            if (e.lengthComputable) {
                                //calculate the percentage loaded
                                var pct = (e.loaded / e.total);
                                //log percentage loaded
                                NProgress.set(pct);
                            }
                        }
                    });
                },
                error: function () {
                    if (confirm("Tải dữ liệu bị lỗi!\nBạn có muốn tải lại?")) {
                        taiDulieu(true);
                    } else {
                        location.reload()
                    }
                },
                progress: function (e) {
                    //make sure we can compute the length
                    if (e.lengthComputable) {
                        //calculate the percentage loaded
                        var pct = (e.loaded / e.total);
                        //log percentage loaded
                        NProgress.set(pct);
                        $('#trangthaitai').text(parseInt(pct * 100) + "%");
                    }
                }
            });
        }

        //Tách id hàng từ mã hàng
        function tachID(ma) {
//            var id = ma.substring(ma.indexOf('-') + 1, ma.length);
//            id = id.substring(id.indexOf('-') + 1, id.length);
//            return id;
            if (ma != '') {
                for (var i = 0; i < sanphams.length; i++) {
                    if (sanphams[i]['ma_sp'] == ma) {
                        return sanphams[i]['id'];
                    }
                }
            }
            return null;
        }

        //Nhập mã hàng
        o_nhapma.keypress(function (e) {
            if (e.which == 13) {
                var ma = o_nhapma.val().toUpperCase().trim();
                o_nhapma.val('');
                o_nhapma.focus();

                //Lấy id sp ma-size-id
                var id = tachID(ma);
                //console.log('Đã add id: '+id);

                if (!dathang) {
                    for (var i = 0; i < sanphams.length; i++) {
                        if (sanphams[i]['id'] == id) {
                            //Thêm vào bảng
                            if (sanphams[i]['SL_sp'] > 0) {
                                if (typeof sp_dachon[id] !== 'undefined') {
                                    if (sanphams[i]['SL_sp'] > sp_dachon[id]['SL_MUA']) {
                                        sp_dachon[id]['SL_MUA']++;
                                    } else {
                                        $.notify('Hàng đã được chọn hết cho khách hàng!', 'error')
                                    }
                                } else {
                                    sp_dachon[id] = sanphams[i];
                                    sp_dachon[id]['thoigianbook'] = Date();
                                    sp_dachon[id]['SL_MUA'] = 1;
                                }
                                hienthi();
                            } else {
                                $.notify('Sản phẩm này đã hết hàng!', 'error')
                            }
                            break;
                        }
                    }
                } else {
                    for (i = 0; i < sanphams.length; i++) {
                        if (sanphams[i]['id'] == id) {
                            //Thêm vào bảng
                            if (typeof sp_dachon[id] !== 'undefined') {

                                sp_dachon[id]['SL_MUA']++;

                            } else {
                                sp_dachon[id] = sanphams[i];
                                sp_dachon[id]['thoigianbook'] = Date();
                                sp_dachon[id]['SL_MUA'] = 1;
                            }
                            hienthi();
                            break;
                        }
                    }
                }
            }
        });

        //Load lên menu hàng và menu khách hàng
        function loadLenMenu() {
            var html = '';
            for (var h = 0; h < sanphams.length; h++) {
                html += "<option value='" + sanphams[h]['ma_sp'] + "'>";
            }
            $('#list_masp').html(html);
            html = '';
            for (h = 0; h < khachhangs.length; h++) {
                html += "<option value='" + khachhangs[h]['sdt'] + "'>";
            }
            $('#list_kh').html(html);
        }

        // sắp sếp sản phẩm book theo thứ tự thời
        function sortSPDaChon(spdachon) {
            var keys = Object.keys(spdachon);
            for (var i=0; i<keys.length; i++) {
                for (var j = i+1; j<keys.length; j++) {
                    if(spdachon[keys[i]]['thoigianbook'] > spdachon[keys[j]]['thoigianbook']) {
                        var objMinDate = spdachon[keys[j]];
                        spdachon[keys[j]] = spdachon[keys[i]];
                        spdachon[keys[i]] = objMinDate;
                    }
                }
            }
            return spdachon;
        }

        //Hiển thị lên bảng
        function hienthi() {
            //Hiển thị sản phẩm đã chọn
            var html = '';
            var tt = 0;
            var tongtien = 0;
            var tongKM = 0;
            var spdachon_ht = {};
            for (var i in sp_dachon) {
                spdachon_ht[i] = sp_dachon[i];
            }
            spdachon_ht = sortSPDaChon(spdachon_ht);
            for (var j in spdachon_ht) {
                spdachon_ht[j]['Tong'] = spdachon_ht[j]['SL_MUA'] * spdachon_ht[j]['giaKM_sp'];
                tongtien += spdachon_ht[j]['SL_MUA'] * spdachon_ht[j]['gia_sp'];
                tongKM += spdachon_ht[j]['Tong'];
                html += "<tr>" +
                    "<td>" + (tt+1) + "</td>" +
                    "<td>" + spdachon_ht[j]['ma_sp'] + "</td>" +
                    "<td>" + spdachon_ht[j]['ten_sp'] + "</td>" +
                    "<td>" + dinhdangNUMBER(spdachon_ht[j]['gia_sp']) + "</td>";
                if (CD_suagiaKM) {
                    html += "<td>" +
                        "<button onclick='thaydoikhuyenmai(" + spdachon_ht[j]['id'] + ")' class='btn btn-primary btn-xs'>" +
                        "<i class='fa fa-edit'></i></button> <span class='tien'>" + spdachon_ht[j]['giaKM_sp'] +
                        "</span></td>";
                } else {
                    html += "<td>" + dinhdangNUMBER(spdachon_ht[j]['giaKM_sp']) + "</td>";
                }
                html += "<td><div class='btn-group'>" +
                    "<button onclick='themSL(" + spdachon_ht[j]['id'] + ");' class='btn btn-default btn-xs'><i class='fa fa-chevron-up'></i> Thêm</button>" +
                    "<button class='btn btn-primary btn-xs'>" + spdachon_ht[j]['SL_MUA'] + "</button>" +
                    "<button onclick='botSL(" + spdachon_ht[j]['id'] + ");' class='btn btn-default btn-xs'><i class='fa fa-chevron-down'></i> Bớt</button>" +
                    "</div></td>" +

                    "<td>" + dinhdangNUMBER(spdachon_ht[j]['Tong']) + "</td>" +
                    "<td><button onclick='xoaSP(" + spdachon_ht[j]['id'] + ");' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></button></td>" +
                    "</tr>";
                tt++;
            }
            html += "<tr class='bg-lightgray'>" +
                "<td colspan='6' class='text-right'>Tổng giá trị sản phẩm: </td>" +
                "<td colspan='2' class='text-bold'>" + dinhdangNUMBER(tongtien) + "</td>" +
                "</tr>";
            html += "<tr class='bg-lightgray'>" +
                "<td colspan='6' class='text-right'>Tổng khuyến mãi: </td>" +
                "<td colspan='2' class='text-bold'>" + dinhdangNUMBER(tongtien - tongKM) + "</td>" +
                "</tr>";
            if (DD_giamgia) {
                html += "<tr class='bg-lightgray'>" +
                    "<td colspan='6' class='text-right'>Khuyễn mãi voucher: </td>" +
                    "<td colspan='2' class='text-bold'>" + dinhdangNUMBER(GT_giamgia) + "</td>" +
                    "</tr>";
                html += "<tr class='bg-lightgray'>" +
                    "<td colspan='6' class='text-right'>Khách hàng cần chi trả: </td>" +
                    "<td colspan='2' class='text-bold text-red'>" + dinhdangNUMBER(tongKM - parseInt(GT_giamgia)) + "</td>" +
                    "</tr>";
            } else {
                html += "<tr class='bg-lightgray'>" +
                    "<td colspan='6' class='text-right'>Khách hàng cần chi trả: </td>" +
                    "<td colspan='2' class='text-bold text-red'>" + dinhdangNUMBER(tongKM) + "</td>" +
                    "</tr>";
            }


            table.html(html);
            sp_dachon_sl = tt;
            //reloadTien();
        }

        //Thay đổi số lựog
        function themSL(id) {
            if (!dathang) {
                if (sp_dachon[id]['SL_sp'] > sp_dachon[id]['SL_MUA']) {
                    sp_dachon[id]['SL_MUA']++;
                    hienthi();
                } else {
                    $.notify('Không có đủ hàng để thêm!', 'error')
                }
            } else {
                sp_dachon[id]['SL_MUA']++;
                hienthi();
            }
        }

        function botSL(id) {
            if (sp_dachon[id]['SL_MUA'] > 0) {
                sp_dachon[id]['SL_MUA']--;
                hienthi();
            } else {
                $.notify('Không thể bớt số lượng được nữa!', 'error')
            }
        }

        //Xóa sản phẩm đã chọn
        function xoaSP(id) {
            delete sp_dachon[id];
            hienthi();
        }

        var khTam = true;
        var donhangonline = false;

        function dienThongTinKHTam() {
            $('#sdt').val("0967487179");
            dienthongtinKH();
        }

        //Lưu hóa đơn
        $('#luuHD').click(function () {
            $('#luuHD').prop( "disabled", true );
            setTimeout(function () {
                $('#luuHD').prop( "disabled",false);
            },5000);
            if (khachno) {
                if (!confirm('Hóa đơn này khách có nợ lại tiền\nBạn có muốn tiếp tục?')) {
                    return;
                }
            }

            if(donhangonline) {
                khTam = false;
            } else {
                khTam = true;
            }

            if ($('#sdt').val().trim() == '') {
                if(khTam) {
                    dienThongTinKHTam();
                } else {
                    alert("Bạn cần số điện thoại khách hàng cho hóa đơn này!");
                    $('#sdt').focus();
                    return;
                }
            }
            if ($('#hoten').val().trim() == '') {
                alert("Bạn cần điền họ tên khách hàng cho hóa đơn này!");
                $('#hoten').focus();
                return;
            }

            if(donhangonline) {
                if ($('#diachi').val().trim() == '') {
                    alert("Bạn cần điền địa chỉ khách hàng cho hóa đơn này!");
                    $('#diachi').focus();
                    return;
                }

                if ($('#ghichu').val().trim() == '') {
                    alert("Bạn cần điền thêm thông tin ghi chú cho hoá đơn này gồm: Mã đơn vận, tên instagraminstagram hoặc facebook, loại đơn online(COD hoặc chuyển khoảng)");
                    $('#ghichu').focus();
                    return;
                }
            }
            

            if (sp_dachon_sl == 0) {
                alert("Chưa có sản phẩm nào để thêm!");
                return;
            }
            var tuoi = moment().diff($('#ngaysinh').data('daterangepicker').startDate, 'years');
            if (parseInt(tuoi) <= 10) {
                if (!confirm("Khách hàng bạn nhập đang dưới 10 tuổi.\nBạn có chắc đã nhập đúng ngày sinh khách hàng?")) {
                    $('#ngaysinh').focus();
                    return;
                }
            }

            $('#luuHD').html("<i class='fa fa-spin fa-refresh'></i> Đang lưu..");
            $('#luuHD').attr('disabled', true);
            if (dathang) {
                taomaDH();
            } else {
                taomaHD()
            }
            themKH();
        });

        function inHD() {
            var hoadon = $('#hoadon');
            var tr_dathang_ngaynhan = '';
            //Nạp thông số
            var html_hoadon = template_hoadon;
            //Điền
            if (dathang) {
                html_hoadon = html_hoadon.replace('{tieude_hoadon}', "HÓA ĐƠN ĐẶT HÀNG");
                tr_dathang_ngaynhan = "<tr class='bg-lightgray'>" +
                    "<td colspan='2' class='text-right'>Ngày nhận hàng: </td>" +
                    "<td colspan='1' class='text-bold text-red'>" + (ngay_dathang) + "</td>" +
                    "</tr>";
                tienkhachtra = tien_dathang;
            } else {
                html_hoadon = html_hoadon.replace('{tieude_hoadon}', "HÓA ĐƠN BÁN HÀNG");
                tr_dathang_ngaynhan = "";
            }
            html_hoadon = html_hoadon.replace('{Ma_HD}', mahd);
            html_hoadon = html_hoadon.replace('{Diachi_shop}', diachidaily_hd);
            html_hoadon = html_hoadon.replace('{SDT_shop}', sdtdaily_hd);
            html_hoadon = html_hoadon.replace('{MATICHDIEM}', matichdiem);
            html_hoadon = html_hoadon.replace('{Ten_KH}', $('#hoten').val());
            html_hoadon = html_hoadon.replace('{Diachi_KH}', $('#diachi').val());
            html_hoadon = html_hoadon.replace('{SDT_KH}', $('#sdt').val());
            html_hoadon = html_hoadon.replace('{Nhan_vien_ban_hang}', '{!! $nhanvien->name !!}');
            //html_hoadon = html_hoadon.replace('{Ghi_Chu}', );
            html_hoadon = html_hoadon.replace('{Date}', '{!! \App\CusstomPHP\Time::Datenow() !!}');
            hoadon.html(html_hoadon);
            //Nạp hàng
            var html_hang = '';
            var tongtien = 0;
            var tongKM = 0;
            for (var index in sp_dachon) {
                tongtien += sp_dachon[index]['SL_MUA'] * sp_dachon[index]['gia_sp'];
                tongKM += sp_dachon[index]['Tong'];
                html_hang += "<tr>" +
                    "<td>" + sp_dachon[index]['ten_sp'] + "</td>" +
                    "<td>" + dinhdangNUMBER(sp_dachon[index]['gia_sp']) + "</td>" +
                    "<td>" + sp_dachon[index]['SL_MUA'] + "</td>" +
                    "<td>" + dinhdangNUMBER(parseInt(sp_dachon[index]['SL_MUA']) * parseInt(sp_dachon[index]['gia_sp'])) + "</td>" +
                    "</tr>";

            }
            html_hang += "<tr class='bg-lightgray'>" +
                "<td colspan='3' class='text-right'>Tổng tiền hàng: </td>" +
                "<td colspan='1' class='text-bold'>" + dinhdangNUMBER(tongtien) + "</td>" +
                "</tr>";
            html_hang += "<tr class='bg-lightgray'>" +
                "<td colspan='3' class='text-right'>Tổng khuyến mãi: </td>" +
                "<td colspan='1' class='text-bold'>" + dinhdangNUMBER(tongtien - tongKM) + "</td>" +
                "</tr>";

            if (DD_giamgia) {
                html_hang += "<tr class='bg-lightgray'>" +
                    "<td colspan='3' class='text-right'>Khuyễn mãi voucher: </td>" +
                    "<td colspan='1' class='text-bold'>" + dinhdangNUMBER(GT_giamgia) + "</td>" +
                    "</tr>";
                html_hang += "<tr class='bg-lightgray'>" +
                    "<td colspan='3' class='text-right'>Tổng thanh toán: </td>" +
                    "<td colspan='1' class='text-bold text-red'>" + dinhdangNUMBER(tongKM - parseInt(GT_giamgia)) + "</td>" +
                    "</tr>";
            } else {
                html_hang += "<tr class='bg-lightgray'>" +
                    "<td colspan='3' class='text-right'>Tổng thanh toán: </td>" +
                    "<td colspan='1' class='text-bold text-red'>" + dinhdangNUMBER(tongKM) + "</td>" +
                    "</tr>";
            }


            if (CD_khachno) {
                html_hang += "<tr class='bg-lightgray'>" +
                    "<td colspan='3' class='text-right'>Tổng khách đã trả: </td>" +
                    "<td colspan='1' class='text-bold text-red'>" + dinhdangNUMBER(tienkhachtra) + "</td>" +
                    "</tr>";
                html_hang += "<tr class='bg-lightgray'>" +
                    "<td colspan='3' class='text-right'>Tổng khách nợ lại: </td>" +
                    "<td colspan='1' class='text-bold text-red'>" + dinhdangNUMBER(tongKM - tienkhachtra) + "</td>" +
                    "</tr>";
            }
            html_hang += tr_dathang_ngaynhan;
            $('#hang-hd').html(html_hang);
            //reloadTien();
            hoadon.print();
            capnhatSP_hientai();
            $('#luuHD').html("<i class='fa fa-print'></i> Lưu hóa đơn (F9)");
            $('#luuHD').attr('disabled', false);
            offline = false;
            khoiphuc();
            hienthi_btn_dongbo();
        }

        //Lưu hóa đơn lên server
        function luuHDServer() {
            var tongtienHD = 0;
            var tongtienKM = 0;
            var dulieuGUI;
            for (var j in sp_dachon) {
                tongtienKM += sp_dachon[j]['SL_MUA'] * sp_dachon[j]['giaKM_sp'];
                tongtienHD += sp_dachon[j]['SL_MUA'] * sp_dachon[j]['gia_sp'];
            }
            if (DD_giamgia) {
                tongtienKM = tongtienKM - GT_giamgia;
            }
            if (!khachno) {
                tienkhachtra = tongtienKM;
            }
            //Lưu toàn bộ thông tin
            if (dathang) {
                tienkhachtra = tien_dathang;
                dulieuGUI = {
                    id: 'NULL',
                    daily_hd: daily,
                    ma_hd: mahd,
                    id_kh: $('#id_kh').val(),
                    hoten_kh: $('#hoten').val(),
                    sanpham_muas: JSON.stringify(sp_dachon),
                    tongtien_hd: tongtienHD,
                    tienVC_hd: GT_giamgia,
                    tongtienKM_hd: tongtienKM,
                    tongtienKhachTra_hd: tien_dathang,
                    ngaynhan_hd: ngay_dathang,
                    khachhang: {},
                    ngaytao: '',
                    ngaysua: '',
                    trangthai: '{!! \App\CusstomPHP\State::$tt_DangCho !!}',
                    ghichu: $('#ghichu').val(),
                    _token: token
                };
                //Gửi lên đặt hàng
                if (navigator.onLine) {
                    $.post('{!! \App\CusstomPHP\CustomURL::route('them-dathang') !!}', dulieuGUI,
                        function (result) {
                            if (result['success']) {
                                $.notify('Thêm hóa đơn đặt hàng thành công!', 'success');
                                inHD();
                            } else {
                                luuLOCAL(dulieuGUI, false, true);
                                $.notify('Thêm hóa đơn đặt hàng lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại', 'warn');
                                inHD();
                            }
                        }).error(function () {
                        luuLOCAL(dulieuGUI, false, true);
                        $.notify('Thêm hóa đơn đặt hàng lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại', 'warn');
                        inHD();
                    })
                } else {
                    luuLOCAL(dulieuGUI, false, true);
                    $.notify('Thêm hóa đơn đặt hàng lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại', 'warn');
                    inHD();
                }
            } else {
                dulieuGUI = {
                    id: 'NULL',
                    daily_hd: daily,
                    ma_hd: mahd,
                    id_kh: $('#id_kh').val(),
                    hoten_kh: $('#hoten').val(),
                    sanpham_muas: JSON.stringify(sp_dachon),
                    tongtien_hd: tongtienHD,
                    tienVC_hd: GT_giamgia,
                    tongtienKM_hd: tongtienKM,
                    tongtienKhachTra_hd: tienkhachtra,
                    phantramKM_hd: GT_khuyenmai,
                    khachhang: {},
                    ngaytao: '',
                    ngaysua: '',
                    trangthai: '{!! \App\CusstomPHP\State::$tt_Hoantat !!}',
                    ghichu: $('#ghichu').val(),
                    _token: token,
                };
                if (DD_giamgia) {
                    dulieuGUI['code'] = GT_code;
                }
                //Gửi lên hóa đơn
                if (navigator.onLine) {
                    $.post('{!! \App\CusstomPHP\CustomURL::route('them-hoadon') !!}', dulieuGUI,
                        function (result) {
                            if (result['success']) {
                                $.notify('Thêm hóa đơn thành công!', 'success');
                                matichdiem = result['code'];
                                inHD();
                            } else {
                                luuLOCAL(dulieuGUI, true, false);
                                $.notify('Thêm hóa đơn lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại!', 'warn');
                                matichdiem = '';
                                inHD();
                            }
                        }).error(function () {
                        luuLOCAL(dulieuGUI, true, false);
                        $.notify('Thêm hóa đơn lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại!', 'warn');
                        matichdiem = '';
                        inHD();
                    })
                } else {
                    luuLOCAL(dulieuGUI, true, false);
                    $.notify('Thêm hóa đơn lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại!', 'warn');
                    matichdiem = '';
                    inHD();
                }
            }
        }


        function themKH() {
            if (!kh_tontai) {
                if (navigator.onLine) {
                    $.post('{!! \App\CusstomPHP\CustomURL::route('them-khachhang') !!}', {
                        _token: token,
                        hoten: $('#hoten').val(),
                        gioitinh: $('#gioitinh').val(),
                        sdt: $('#sdt').val(),
                        diachi: $('#diachi').val(),
                        ngaysinh: $('#ngaysinh').data('daterangepicker').startDate.format('DD/MM/YYYY'),
                        chinhanh: daily
                    }, function (result) {
                        if (result['success']) {
                            $.notify('Thêm khách hàng thành công!', 'success');
                            $('#id_kh').val(result['id']);
                            kh_tontai = true;
                            luuHDServer();
                        } else {
                            $.notify('Thêm khách hàng lỗi!', 'error');
                            $('#id_kh').val('0');
                            luuHDServer();
                        }
                    }).error(function () {
                        $.notify('Lỗi kết nối máy chủ!', 'error');
                        $('#id_kh').val('0');
                        luuHDServer();
                    })
                } else {
                    $('#id_kh').val('0');
                    luuHDServer();
                }
            } else {
                var id_KH_NS = $('#id_kh').val();
                var dieukiendoingaysinh = false;
                for (var i = 0; i < khachhangs.length; i++) {
                    if (khachhangs[i]['id'] == id_KH_NS) {
                        if (khachhangs[i]['ngaysinh'].trim() == '' && $('#sdt').val().trim() != '') {
                            //Sửa ngày sinh
                            if ($('#ngaysinh').data('daterangepicker').startDate.format('DD/MM/YYYY') != '01/01/2000') {
                                dieukiendoingaysinh = true;
                            }
                        }
                        break;
                    }
                }
                if (dieukiendoingaysinh) {
                    if (navigator.onLine) {
                        $.post('{!! \App\CusstomPHP\CustomURL::route('suaNgaySinhKH-khachhang') !!}', {
                            _token: token,
                            id: $('#id_kh').val(),
                            ngaysinh: $('#ngaysinh').data('daterangepicker').startDate.format('DD/MM/YYYY')
                        }, function (result) {
                            if (result['success']) {
                                $.notify('Sửa ngày sinh khách hàng thành công!', 'success');
                                luuHDServer();
                            } else {
                                $.notify('Sửa ngày sinh khách hàng lỗi!', 'error');
                                luuHDServer();
                            }
                        }).error(function () {
                            $.notify('Lỗi kết nối máy chủ!', 'error');
                            luuHDServer();
                        })
                    } else {
                        luuHDServer();
                    }
                } else {
                    luuHDServer();
                }
            }
        }


        //Khôi phụ trạng thái
        function khoiphuc() {
            taomaHD();
            $('#bang_hang_body').html('');
            $('input').val('');
            $('textarea').val('');
            kh_tontai = false;
            khachno = false;
            dathang = false;
            ngay_dathang = '';
            tien_dathang = 0;
            tienkhachtra = 0;
            matichdiem = '';
            $('#khachno').iCheck('uncheck');
            $('#dathang').iCheck('uncheck');
            $('#donhangonline').iCheck('uncheck');
            o_nhapma.focus();
            for (var j in sp_dachon) {
                delete sp_dachon[j];
            }
            hienthi();
            loadLenMenu();
            table.html('');
            hienthi_btn_dongbo();
            DD_giamgia = false;
            GT_giamgia = 0;
            GT_khuyenmai = 0;
            DD_khuyenmai = false;
            btn_khuyenmai.removeClass('btn-danger');
            btn_khuyenmai.addClass('btn-primary');
            btn_khuyenmai.html("<i class='fa fa-shekel'></i> Khuyến mãi");
            //
            kh_dangchon = null;
            btn_magiamgia.removeClass('btn-primary');
            btn_magiamgia.addClass('btn-primary');
        }

        $('#sdt').keypress(function (e) {
            if (e.which == 13) {
                dienthongtinKH();
            }
        });
        $('#sdt').focusout(function () {
            dienthongtinKH();
        });

        function dienthongtinKH() {
            kh_tontai = false;
            if ($('#sdt').val().trim() != '') {
                for (var i = 0; i < khachhangs.length; i++) {
                    if (khachhangs[i]['sdt'] == $('#sdt').val().trim()) {
                        $('#hoten').val(khachhangs[i]['hoten']);
                        $('#gioitinh').val(khachhangs[i]['gioitinh']);
                        $('#diachi').val(khachhangs[i]['diachi']);
                        if (khachhangs[i]['ngaysinh'] != '') {
                            $('#ngaysinh').data('daterangepicker').setStartDate(khachhangs[i]['ngaysinh']);
                        } else {
                            $('#ngaysinh').data('daterangepicker').setStartDate('01/01/2000');
                        }
                        $('#id_kh').val(khachhangs[i]['id']);
                        kh_dangchon = khachhangs[i];
                        $.notify('Khách hàng được điền tự động!', 'success');
                        kh_tontai = true;

                        if (kh_dangchon['luot'] >= parseInt('{!! \App\CusstomPHP\Cauhinhs::getCauHinh('muatoithieu') !!}')) {
                            btn_magiamgia.addClass('btn-primary');
                            btn_magiamgia.removeClass('btn-primary');
                        } else {
                            btn_magiamgia.removeClass('btn-primary');
                            btn_magiamgia.addClass('btn-primary');
                        }
                        return;
                    }
                }
            }
            kh_dangchon = null;
            btn_magiamgia.removeClass('btn-primary');
            btn_magiamgia.addClass('btn-primary');
            $('#hoten').val('');
            $('#gioitinh').val('');
            $('#diachi').val('');
            $('#ngaysinh').data('daterangepicker').setStartDate('01/01/2000');
            $('#id_kh').val('');
            kh_tontai = false;
            return;
        }

        function taomaHD() {
            mahd = "HD" + Date.now();
        }

        function taomaDH() {
            mahd = "DH" + Date.now();
        }

        function capnhatSP_hientai() {
            for (var j in sp_dachon) {
                var idchon = j;
                var slmua = sp_dachon[j]['SL_MUA'];
                for (var i = 0; i < sanphams.length; i++) {
                    if (sanphams[i]['id'] == idchon) {
                        sanphams[i]['SL_sp'] = (sanphams[i]['SL_sp'] - slmua);
                        console.log("Cập nhật lại; " + idchon + "- " + sanphams[i]['SL_sp'])
                    }
                }
            }
        }

        //Hiển thị hàng
        var hienthihangxem = $('#hienthihangxem');
        $('#input_hienthihang').keypress(function (e) {
            if (e.which == 13) {
                var id = tachID($(this).val());
                for (var i = 0; i < sanphams.length; i++) {
                    if (sanphams[i]['id'] == id) {
                        //Thêm vào bảng
                        var html = '';
                        html += "<li>Tên sản phẩm: " + sanphams[i]['ten_sp'] + "</li>";
                        html += "<li>Đơn vị tính: " + sanphams[i]['donvi_sp'] + "</li>";
                        html += "<li>Giá: " + sanphams[i]['gia_sp'] + "</li>";
                        html += "<li>Giá khuyến mãi: " + sanphams[i]['giaKM_sp'] + "</li>";
                        html += "<li>Số lượng: " + sanphams[i]['SL_sp'] + "</li>";
                        html += "<li>Ghi chú: " + sanphams[i]['ghichu_sp'] + "</li>";
                        hienthihangxem.html(html);
                        html = '';
                        break;
                    }
                }
            }
        });
        //Phím tắt
        $(document).bind('keydown', 'f6', function () {
            $('#masp').focus();
            return false;
        });
        $(document).bind('keydown', 'f9', function () {
            $('#luuHD').click();
            return false;
        });
        $(document).bind('keydown', 'f7', function () {
            khoiphuc();
            return false;
        });
        $(document).bind('keydown', 'f8', function () {
            $('#btn_hienthihang').click();
            return false;
        });
        var key_nhap = $('.key_nhap');
        key_nhap.bind('keydown', 'f6', function () {
            $('#masp').focus();
            return false;
        });
        key_nhap.bind('keydown', 'f9', function () {
            $('#luuHD').click();
            return false;
        });
        key_nhap.bind('keydown', 'f7', function () {
            khoiphuc();
            return false;
        });
        key_nhap.bind('keydown', 'f8', function () {
            $('#btn_hienthihang').click();
            return false;
        });
        $(window).on("beforeunload", function () {
            return "Trang đang bán hàng, nếu thoát dữ liệu bạn đang nhập sẽ mất!\nBạn có muốn thoát?";
        });

        //Thay đổi giá khuyến mãi
        function thaydoikhuyenmai(id) {
            var giacu = sp_dachon[id]['giaKM_sp'];
            var giamoi = prompt('Nhập giá khuyến mãi mới:', giacu);
            if (giamoi == null) {
                return;
            }
            if ($.isNumeric(giamoi) != true) {
                alert("Bạn vừa nhập không phải là số!");
                return;
            }
            if (giacu != giamoi) {
                if (confirm("Bạn có chắc muốn thay đổi giá khuyến mãi với hóa đơn này?")) {
                    sp_dachon[id]['giaKM_sp'] = giamoi;
                    hienthi();
                    $('#ghichu').val("Đã đổi giá khuyến mãi");
                }
            }
        }

        $('.nutcheck').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });
        $('#khachno').on('ifChanged', function (event) {
            if (this.checked == true) {
                $('.modal-khachno').modal('show');
                if (tienkhachtra == 0) {
                    var tongtienTra = 0;
                    for (var j in sp_dachon) {
                        tongtienTra += sp_dachon[j]['SL_MUA'] * sp_dachon[j]['giaKM_sp'];
                    }
                    $('#input_tienkhachno').autoNumeric('set', tongtienTra);
                } else {
                    $('#input_tienkhachno').autoNumeric('set', tienkhachtra);
                }
                khachno = true;
            } else {
                khachno = false;
                tienkhachtra = 0;
            }
        });
        $('#btn_luutienkhachno').click(function () {
            tienkhachtra = $('#input_tienkhachno').autoNumeric('get');
        });

        ///////////////////////////////////////////////////////////////////////////
        $('#dathang').on('ifChanged', function (event) {
            if (this.checked == true) {
                $('.modal-dathang').modal('show');
                $('#luuHD').html("<i class='fa fa-shopping-bag'></i> Lưu đặt hàng (F9)");
                $('#luuHD').removeClass('btn-primary');
                $('#luuHD').addClass('btn-info');
                var html = '';
                for (var h = 0; h < sanphams.length; h++) {
                    html += "<option value='" + sanphams[h]['ma_sp'] + "'>";
                }
                $('#list_masp').html(html);
                $.notify('Chế độ đặt hàng kích hoạt!', 'warn');
                dathang = true;
                taomaDH();
            } else {
                $('#luuHD').html("<i class='fa fa-print'></i> Lưu hóa đơn (F9)");
                $('#luuHD').removeClass('btn-info');
                $('#luuHD').addClass('btn-primary');
                var html = '';
                for (var h = 0; h < sanphams.length; h++) {
                    if (sanphams[h]['SL_sp'] > 0) {
                        html += "<option value='" + sanphams[h]['ma_sp'] + "'>";
                    }
                }
                $('#list_masp').html(html);
                $.notify('Chế độ đặt hàng vô hiệu hóa!', 'warn');
                dathang = false;
                taomaHD()
            }
        });

        $('#donhangonline').on('ifChanged', function (event) {
            if (this.checked == true) {
                $.notify('Chế độ đặt hàng online được kích hoạt!', 'warn');
                donhangonline = true;
            } else {
                $.notify('Chế độ đặt hàng online vô hiệu hóa!', 'warn');
                donhangonline = false;
            }
        });

        $('#btn_luudathang').click(function () {
            tien_dathang = $('#input_tienkhachdat').autoNumeric('get');
            ngay_dathang = $('#input_ngaynhanhang').val();
        });

        //Lưu dữ liệu bàn hàng nếu lỗi vào local
        var danhsachLuuLOCAL = []; //Lưu danh sách các tên item lưu
        var dongbo_btn = $('#dongbohoadon');

        function luuLOCAL(dulieu, is_hoadon, is_dathang) {
            if (localStorage.getItem('danhsach') != null) {
                danhsachLuuLOCAL = JSON.parse(localStorage.getItem('danhsach'));
            } else {
                danhsachLuuLOCAL = [];
            }
            var new_item = Date.now();
            if (is_hoadon) {
                danhsachLuuLOCAL[danhsachLuuLOCAL.length] = {kieu: 'hoadon', name: new_item};
            }
            if (is_dathang) {
                danhsachLuuLOCAL[danhsachLuuLOCAL.length] = {kieu: 'dathang', name: new_item};
            }
            localStorage.setItem(new_item, JSON.stringify(dulieu));
            localStorage.setItem('danhsach', JSON.stringify(danhsachLuuLOCAL));
            saveHDToCookie(dulieu, danhsachLuuLOCAL);
            hienthi_btn_dongbo();
        }

        function resetHDFromCookie() {
            document.cookie = "localStorage=";
        }

        function saveHDToCookie(dulieu, danhsachLuuLOCAL){
            document.cookie = "localStorage=" + JSON.stringify(localStorage);
        }

        function getHDFromCookie() {
            var namelocalStorage = "localStorage="
            var ca = document.cookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(namelocalStorage) == 0) {
                    var data = c.substring(namelocalStorage.length, c.length);
                    if (data.length > 0) {
                        localStorage = JSON.parse(data);
                    }
                }
            }
        }

        function hienthi_btn_dongbo() {
            if (localStorage.getItem('danhsach') != null && localStorage.getItem('danhsach').length !=0) {
                danhsachLuuLOCAL = JSON.parse(localStorage.getItem('danhsach'));
                dongbo_btn.removeClass('btn-primary');
                dongbo_btn.addClass('btn-primary');
                dongbo_btn.html("<i class='fa fa-cloud-upload'></i> Đồng bộ hóa đơn (" + danhsachLuuLOCAL.length + ")");
                dongbo_btn.prop( "disabled",false);
            } else {
                dongbo_btn.removeClass('btn-primary');
                dongbo_btn.addClass('btn-primary');
                dongbo_btn.html("<i class='fa fa-cloud-upload'></i> Đồng bộ hóa đơn");
            }
        }

        //Nhấn nút đồng bộ
        dongbo_btn.click(function () {
            if (navigator.onLine) {
                if (localStorage.getItem('danhsach') != null) {
                    danhsachLuuLOCAL = JSON.parse(localStorage.getItem('danhsach'));
                    if (confirm('Bạn có muốn lưu ' + danhsachLuuLOCAL.length + ' hóa đơn chưa được lưu lên máy chủ?')) {
                        for (var i = 0; i < danhsachLuuLOCAL.length; i++) {
                            var hd = danhsachLuuLOCAL[i];
                            if (hd['kieu'] == 'hoadon') {
                                var hoadon = JSON.parse(localStorage.getItem(hd['name']));
                                hoadon['_token'] = token;
                                //Gửi lên hóa đơn
                                $.post('{!! \App\CusstomPHP\CustomURL::route('them-hoadon') !!}', hoadon,
                                    function (result) {
                                        if (result['success']) {
                                            $.notify('Thêm hóa đơn thành công!', 'success');
                                            dongbo_btn.prop( "disabled",true);
                                            matichdiem = result['code'];
                                        } else {
                                            luuLOCAL(hoadon, true, false);
                                            $.notify('Thêm hóa đơn lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại!', 'warn');
                                        }
                                    }).error(function () {
                                    luuLOCAL(hoadon, true, false);
                                    $.notify('Thêm hóa đơn lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại!', 'warn');
                                });
                            }
                            if (hd['kieu'] == 'dathang') {
                                var dathang = JSON.parse(localStorage.getItem(hd['name']));
                                dathang['_token'] = token;
                                //Gửi lên đặt hàng
                                $.post('{!! \App\CusstomPHP\CustomURL::route('them-dathang') !!}', dathang,
                                    function (result) {
                                        if (result['success']) {
                                            $.notify('Thêm hóa đơn đặt hàng thành công!', 'success');
                                            dongbo_btn.prop( "disabled",true);
                                        } else {
                                            luuLOCAL(dulieuGUI, false, true);
                                            $.notify('Thêm hóa đơn đặt hàng lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại', 'warn');
                                        }
                                    }).error(function () {
                                    luuLOCAL(dulieuGUI, false, true);
                                    $.notify('Thêm hóa đơn đặt hàng lỗi do mạng. Vui lòng đồng bộ lại ngay khi có mạng trở lại', 'warn');
                                })
                            }
                        }
                        localStorage.clear();
                    }
                }
            } else {
                $.notify('Không có kêt nối mạng!', 'warn');
            }
            hienthi_btn_dongbo();
        });

        //Nhập mã voucher
        var gt_1diemthuong = '{!! \App\CusstomPHP\Tables::getValue('donvi_diem',\App\CusstomPHP\Tables::$tb_khachhang_cauhinhs) !!}';
        btn_magiamgia.click(function () {
            if (kh_dangchon != null) {
                if (kh_dangchon['luot'] >= parseInt('{!! \App\CusstomPHP\Cauhinhs::getCauHinh('muatoithieu') !!}')) {
                    if (!confirm("Bạn có muốn sử dụng điểm tích của khách hàng để giảm giá cho hóa đơn này?")) {
                        DD_giamgia = false;
                        GT_giamgia = 0;
                        hienthi();
                        return;
                    }
                    var gt = prompt("Khách muốn trả từ điểm thưởng bao nhiêu (nhỏ hơn " + dinhdangNUMBER(kh_dangchon['diem'] * parseInt(gt_1diemthuong)) + ")?");

                    if ($.isNumeric(gt)) {
                        if (kh_dangchon['diem'] * parseInt(gt_1diemthuong) >= parseInt(gt)) {
                            $.notify("Mã giảm giá được áp dụng!", 'success');
                            DD_giamgia = true;
                            GT_giamgia = gt;
                            hienthi();
                        } else {
                            DD_giamgia = false;
                            GT_giamgia = 0;
                            hienthi();
                            $.notify("Số tiền nhập lớn hơn số tiền khách hàng tích được!", 'error');
                        }
                    }
                } else {
                    alert('Khách hàng chưa đủ điều kiện sử dụng điểm tích được để giảm giá hóa đơn!');
                }
            } else {
                $.notify('Chưa chọn khách hàng!', 'warn');
            }
        });

        //In hóa đơn hôm nay
        btn_inhoadonngay.click(function () {
            //Lấy danh sách hóa đơn trên mạng
            var hoadon_today;
            var sanpham_today;
            $.post('{!! \App\CusstomPHP\CustomURL::route('gethoadonTODAY-ajax') !!}',
                {
                    _token: token
                }, function (result) {
                    hoadon_today = result;
                    var hoadon = $('#hoadon');
                    //Nạp thông số
                    var html_hoadon = template_hoadon;
                    html_hoadon = html_hoadon.replace('{tieude_hoadon}', "HÓA ĐƠN BÁN HÀNG CẢ NGÀY");
                    html_hoadon = html_hoadon.replace('{Ma_HD}', 'Không có');
                    html_hoadon = html_hoadon.replace('{Diachi_shop}', diachidaily_hd);
                    html_hoadon = html_hoadon.replace('{SDT_shop}', sdtdaily_hd);
                    html_hoadon = html_hoadon.replace('{MATICHDIEM}', '');
                    html_hoadon = html_hoadon.replace('{Ten_KH}', diachidaily_hd);
                    html_hoadon = html_hoadon.replace('{Diachi_KH}', diachidaily_hd);
                    html_hoadon = html_hoadon.replace('{SDT_KH}', sdtdaily_hd);
                    html_hoadon = html_hoadon.replace('{Nhan_vien_ban_hang}', '{!! $nhanvien->name !!}');
                    //html_hoadon = html_hoadon.replace('{Ghi_Chu}', );
                    html_hoadon = html_hoadon.replace('{Date}', '{!! \App\CusstomPHP\Time::Datenow() !!}');
                    hoadon.html(html_hoadon);
                    //Nạp hàng
                    var html_hang = '';
                    var tongtien = 0;
                    var tongKM = 0;
                    for (var i = 0; i < hoadon_today.length; i++) {
                        sanpham_today = JSON.parse(hoadon_today[i]['sanpham_muas']);
                        //
                        html_hang += "<tr>" +
                            "<td colspan='3' style='text-align: center'>" + hoadon_today[i]['ma_hd'] + "</td>" +
                            "</tr>";
                        for (var index in sanpham_today) {
                            tongtien += sanpham_today[index]['SL_MUA'] * sanpham_today[index]['gia_sp'];
                            tongKM += sanpham_today[index]['Tong'];
                            html_hang += "<tr>" +
                                "<td>" + sanpham_today[index]['ten_sp'] + "</td>" +
                                "<td>" + dinhdangNUMBER(sanpham_today[index]['gia_sp']) + "</td>" +
                                "<td>" + sanpham_today[index]['SL_MUA'] + "</td>" +
                                "<td>" + dinhdangNUMBER(parseInt(sanpham_today[index]['SL_MUA']) * parseInt(sanpham_today[index]['gia_sp'])) + "</td>" +
                                "</tr>";

                        }
                    }
                    html_hang += "<tr class='bg-lightgray'>" +
                        "<td colspan='3' class='text-right'>Tổng tiền hàng: </td>" +
                        "<td colspan='1' class='text-bold'>" + dinhdangNUMBER(tongtien) + "</td>" +
                        "</tr>";
                    html_hang += "<tr class='bg-lightgray'>" +
                        "<td colspan='3' class='text-right'>Tổng khuyến mãi: </td>" +
                        "<td colspan='1' class='text-bold'>" + dinhdangNUMBER(tongtien - tongKM) + "</td>" +
                        "</tr>";
                    html_hang += "<tr class='bg-lightgray'>" +
                        "<td colspan='3' class='text-right'>Tổng khách trả: </td>" +
                        "<td colspan='1' class='text-bold'>" + dinhdangNUMBER(tongKM) + "</td>" +
                        "</tr>";
                    $('#hang-hd').html(html_hang);
                    //reloadTien();
                    hoadon.print();
                })
        });
        //Nhập khuyến mãi ##khuyenmai
        btn_khuyenmai.click(function () {
            var value = prompt("Nhập khuyễn mãi (%):", 0);
            if (value != null) {
                if ($.isNumeric(value)) {
                    value = parseInt(value);
                    if (value >= 0 && value <= 100) {
                        DD_khuyenmai = true;
                        GT_khuyenmai = value;
                        btn_khuyenmai.html("<i class='fa fa-shekel'></i> Giảm giá (" + value + "%)");
                        btn_khuyenmai.removeClass('btn-primary');
                        btn_khuyenmai.addClass('btn-danger');
                        //load lại giá các sản phẩm khuyến mãi
                        for (var i in sp_dachon) {
                            sp_dachon[i]['giaKM_sp'] = parseInt(sp_dachon[i]['gia_sp']) - parseInt(sp_dachon[i]['gia_sp']) / 100 * GT_khuyenmai;
                        }
                        hienthi();
                        return false;
                    }
                }
            }
            $.notify('Nhập lỗi giá trị khuyến mãi!', 'error');
            return true;
        });

        //Hiển thị date
        $('#ngaysinh').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "locale": {
                "format": "DD/MM/YYYY",
                "daysOfWeek": [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ],
                "firstDay": 1
            }
        });
        //auto
        setTimeout(function () {
            $('#masp').focus();
        }, 1000);
    </script>
@stop