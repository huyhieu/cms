@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Thông tin đặt hàng
                    <small>Tất cả</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <select id="search_daily" class="form-control input-sm">
                            <option value="">Tất cả đại lý</option>
                            @foreach($chinhanhs as $item)
                                <option value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                            @endforeach
                        </select>
                    </li>
                    <li>
                        <input id="khoangthoigian" class="pull-right form-control input-sm">
                    </li>
                    <li  class="dropdown quanli">
                        <a id="sua" data-toggle="modal" data-target=".modal-hoadon" href="#"
                           class="btn btn-primary btn-sm disabled nut_khoa">
                            <i class="fa fa-h-square"></i>
                            Sửa đặt hàng
                        </a>
                    </li>
                    <li class="dropdown quanli">
                        <a id="xem_hang" href="#" class="btn disabled nut_khoa btn-info btn-sm">
                            <i class="fa fa-street-view"></i>
                            Xem hàng khách đặt
                        </a>
                    </li>
                    <li class="dropdown quanli">
                        <a id="xoa" href="#" class="btn disabled nut_khoa btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                            Xóa đặt hàng
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" onclick="taiDulieu();" class="btn btn-default btn-sm">
                            <i class="fa fa-refresh"></i>
                            Reload
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>

                <table id="banghoadon" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã HĐ</th>
                        <th>Tên khách hàng</th>
                        <th>Đại lý</th>
                        <th>Tổng phải trả</th>
                        <th>Khách trả</th>
                        <th>Ngày giao</th>
                        <th>SL hàng</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody id="noidung_banghoadon">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade modal-hoadon" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="title-modal-sp">Sửa thông tin đặt hàng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mã đặt hàng:</label>
                            <input id="ma_hd" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Khách hàng:</label>
                            <select id="id_kh" class="form-control nhap input-sm">
                                <option value=""></option>
                                @foreach($khachhangs as $item)
                                    <option value="{!! $item->id !!}">{!! $item->hoten !!}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="ten_kh">
                        </div>
                        <div class="col-sm-6">
                            <label>Giá trị sản phẩm(s):</label>
                            <input id="tongtien_hd" type="text" class="form-control tien-input nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Khách hàng phải trả:</label>
                            <input id="tongtienKM_hd" type="text" class="form-control tien-input nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Khách đã trả:</label>
                            <input id="tongtienKhachTra_hd" type="text" class="form-control tien-input nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Ngày giao cho khách:</label>
                            <input id="ngaynhan_hd" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Đại lí:</label>
                            <select id="daily_hd" class="form-control input-sm">
                                @foreach($chinhanhs as $item)
                                    <option value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Trạng thái:</label>
                            <select id="trangthai" class="form-control input-sm">
                                <option value="{!! \App\CusstomPHP\State::$tt_Hoantat !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Hoantat) !!}</option>
                                <option value="{!! \App\CusstomPHP\State::$tt_DangCho !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_DangCho) !!}</option>
                            </select>
                        </div>
                    </div>
                    <label>Ghi chú:</label>
                    <textarea id="ghichu" class="form-control nhap input-sm"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button id="suahoadon_save" type="button" class="btn btn-primary">Sửa đặt hàng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal_xem_hang" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Xem sản phẩm trong đơn đặt hàng</h4>
                </div>
                <div class="modal-body text-center">
                    <table class="table table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã hàng</th>
                            <th>Tên hàng</th>
                            <th>Loại</th>
                            <th>Giá hàng</th>
                            <th>Giá KM</th>
                            <th>SL đặt</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="hienthihang_hd">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section('script')
    {{--DataTable--}}
    {!! \App\CusstomPHP\AssetFile::js('datatable/jquery.dataTables.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.bootstrap.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.buttons.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/buttons.bootstrap.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/buttons.flash.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/buttons.html5.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/buttons.print.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.fixedHeader.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.keyTable.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.responsive.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/responsive.bootstrap.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.scroller.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/jszip.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/pdfmake.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/vfs_fonts.js') !!}

    {!! \App\CusstomPHP\AssetFile::js('datatable/datatable.init.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('JsBarcode/JsBarcode128.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('JsBarcode/download.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datetime/moment.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('daterangepicker/daterangepicker.js') !!}
    {{--///DataTable--}}
    <script>
        var dathangs = [];
        var table = null;
        var id_dangchon = '';

        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_sanpham_dathangs !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                dathangs = result;
                NProgress.done();
                var batdau = moment(batdau_default, 'DD/MM/YYYY');
                var ketthuc = moment(ketthuc_default, 'DD/MM/YYYY');
                hienthi(batdau, ketthuc);
            }).error(function () {
                NProgress.done();
            });
        }
        //Bộ lọc đại lý
        $('#search_daily').change(function () {
            table.column(3).search($(this).val()).draw();
        });

        //Load lên sửa hóa đơn
        $('#sua').click(function () {
            for (var i = 0; i < dathangs.length; i++) {
                if (dathangs[i]['id'] == id_dangchon) {
                    $('#daily_hd').val(dathangs[i]['daily_hd']);
                    $('#ma_hd').val(dathangs[i]['ma_hd']);
                    $('#id_kh').val(dathangs[i]['id_kh']);
                    $('#hoten_kh').val(dathangs[i]['hoten_kh']);
                    $('#tongtien_hd').autoNumeric('set',dathangs[i]['tongtien_hd']);
                    $('#tongtienKM_hd').autoNumeric('set',dathangs[i]['tongtienKM_hd']);
                    $('#tongtienKhachTra_hd').autoNumeric('set',dathangs[i]['tongtienKhachTra_hd']);
                    $('#ngaynhan_hd').val(dathangs[i]['ngaynhan_hd']);
                    $('#trangthai').val(dathangs[i]['trangthai']);
                    $('#ghichu').val(dathangs[i]['ghichu']);
                    break;
                }
            }
        });
        //Lưu hóa đơn lên server
        $('#suahoadon_save').click(function () {
            $.post('{!! \App\CusstomPHP\CustomURL::route('sua-dathang') !!}', {
                id: id_dangchon,
                daily_hd: $('#daily_hd').val(),
                ma_hd: $('#ma_hd').val(),
                id_kh: $('#id_kh').val(),
                hoten_kh: $('#hoten_kh').val(),
                tongtien_hd: $('#tongtien_hd').autoNumeric('get'),
                tongtienKM_hd: $('#tongtienKM_hd').autoNumeric('get'),
                tongtienKhachTra_hd: $('#tongtienKhachTra_hd').autoNumeric('get'),
                ngaynhan_hd: $('#ngaynhan_hd').val(),
                trangthai: $('#trangthai').val(),
                ghichu: $('#ghichu').val(),
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Sửa đơn đặt hàng thành công!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Sửa đơn đặt hàng lỗi!", 'error');
                }
            });
        });
        //Xóa lên server
        $('#xoa').click(function () {
            if (confirm('Bạn có chắc muốn xóa đơn đặt hàng này?')) {
                $.post('{!! \App\CusstomPHP\CustomURL::route('xoa-dathang') !!}', {
                    id: id_dangchon,
                    _token: '{!! csrf_token() !!}'
                }, function (result) {
                    if (result['success']) {
                        $.notify("Xóa đơn đặt hàng thành công!", 'success');
                        window.location.reload();
                    } else {
                        $.notify("Xóa đơn đặt hàng lỗi!", 'error');
                    }
                });
            }
        });
        //Hiển thị sản phẩm lên modal
        var nut_xemhang = $('#xem_hang');
        var hang_hoadon;
        var id_hoadon_hienthi = '';
        nut_xemhang.click(function () {
            nut_xemhang.html("<i class='fa fa-spin fa-refresh'></i> Đang nạp hàng...");
            $.get('{!! \App\CusstomPHP\CustomURL::route('getsp-dathang') !!}', {
                id: id_dangchon,
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                hang_hoadon = result;
                id_hoadon_hienthi = id_dangchon;
                hienthiSPlenModal();
                $('.modal_xem_hang').modal('show');
                nut_xemhang.html("<i class='fa fa-street-view'></i> Xem hàng đơn đặt hàng");
            })
        });
        //Hiển thị hàng lên modal_hoadon
        function hienthiSPlenModal() {
            var result = hang_hoadon;
            var html = '';
            for (var i in result) {
                html += '<tr>';
                html += "<td>" + result[i]['id'] + "</td>";
                html += "<td>" + result[i]['ma_sp'] + "</td>";
                html += "<td>" + result[i]['ten_sp'] + "</td>";
                html += "<td>" + result[i]['loai_sp'] + "</td>";
                html += "<td class='tien'>" + result[i]['gia_sp'] + "</td>";
                html += "<td class='tien'>" + result[i]['giaKM_sp'] + "</td>";
                html += "<td>" + result[i]['SL_MUA'] + "</td>";
                html += "<td class='tien'>" + result[i]['Tong'] + "</td>";
                html += "<td></td>";
                html += '</tr>';
            }
            $('#hienthihang_hd').html(html);
        }
        //Xóa hàng khỏi hóa đơn
        function xoaSPkhoihoadon(id) {
            delete hang_hoadon[id];
            hienthiSPlenModal();
        }

        //Chọn sản phẩm
        var bang_dom = $('#banghoadon');
        bang_dom.find('tbody').on('click', 'tr', function () {
            bang_dom.find('tr').removeClass('selected');
            $(this).toggleClass('selected');
            $('.nut_khoa').removeClass('disabled');
            id_dangchon = bang_dom.find('.selected>td:first-child').text().trim();
        });
        /////////////////////////////////////////////////////////////////////////////////////
        function hienthi(batdau, ketthuc) {
            var html = '';
            var ngaytao;
            NProgress.start();
            for (var i = 0; i < dathangs.length; i++) {
                ngaytao = moment(dathangs[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {
                    html += '<tr>';
                    html += "<td>" + dathangs[i]['id'] + "</td>";
                    html += "<td>" + dathangs[i]['ma_hd'] + "</td>";
                    html += "<td>" + dathangs[i]['hoten_kh'] + "</td>";
                    html += "<td>" + dathangs[i]['daily_hd'] + "</td>";
                    html += "<td class='tien'>" + dathangs[i]['tongtienKM_hd'] + "</td>";
                    html += "<td class='tien'>" + dathangs[i]['tongtienKhachTra_hd'] + "</td>";
                    html += "<td>" + dathangs[i]['ngaynhan_hd'] + "</td>";
                    html += "<td>" + Object.keys(JSON.parse(dathangs[i]['sanpham_muas'])).length + "</td>";
                    html += "<td>" + dathangs[i]['ngaytao'] + "</td>";
                    html += "<td>" + dathangs[i]['ngaysua'] + "</td>";
                    if(dathangs[i]['trangthai']=='{!! \App\CusstomPHP\State::$tt_Hoantat !!}'){
                        html += "<td>{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Hoantat) !!}</td>";
                    }else{
                        html += "<td>{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_DangCho) !!}</td>";
                    }
                    html += "<td>" + dathangs[i]['ghichu'] + "</td>";
                    html += '</tr>';
                }
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            $('#noidung_banghoadon').html(html);
            table = khoitaobang('banghoadon');
            NProgress.done();
            reloadTien();
        }
        /////////////////////////////////////////////////////////////////////////////////////
        var batdau_default=moment();
        var ketthuc_default=moment();
        $(document).ready(function () {
            taiDulieu();
            var start = moment().subtract(29, 'days');
            var end = moment();
            batdau_default=start.format('DD/MM/YYYY');
            ketthuc_default=end.format('DD/MM/YYYY');

            function cb(start, end) {
                $('#khoangthoigian').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }

            $('#khoangthoigian').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Cách đây 7 ngày': [moment().subtract(6, 'days'), moment()],
                    'Cách đây 30 ngày': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Áp dụng",
                    "cancelLabel": "Hủy bỏ",
                    "fromLabel": "Từ",
                    "toLabel": "Tới",
                    "customRangeLabel": "Tùy chỉnh",
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
            }, cb);
            cb(start, end);
        });
        $('#khoangthoigian').on('apply.daterangepicker', function (ev, picker) {
            var batdau = picker.startDate.format('DD/MM/YYYY');
            var ketthuc = picker.endDate.format('DD/MM/YYYY');
            batdau = moment(batdau, 'DD/MM/YYYY');
            ketthuc = moment(ketthuc, 'DD/MM/YYYY');
            hienthi(batdau, ketthuc);
        });
    </script>

@stop