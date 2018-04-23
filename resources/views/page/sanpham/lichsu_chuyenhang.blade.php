@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Lịch sử chuyển hàng
                    <small>Tất cả</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <input id="khoangthoigian" class="pull-right form-control input-sm">
                    </li>
                    <li>
                        <button id="btn_morong" class="btn btn-default btn-sm">
                            <i class="fa fa-compress"></i>
                            Nhóm chuyển hàng
                        </button>
                    </li>
                    <li>
                        <button id="btn_tonghop" class="btn btn-default btn-sm">
                            <i class="fa fa-support"></i>
                            Tổng hợp
                        </button>
                    </li>
                    <li>
                        <button id="btn_khoiphuc" class="btn btn-primary btn-sm">
                            <i class="fa fa-repeat"></i>
                            Khôi phục
                        </button>
                    </li>
                    <li class="dropdown">
                        <a onclick="taiDulieu();" href="#" class="btn btn-default btn-sm">
                            <i class="fa fa-refresh"></i>
                            Reload
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>

                <div id="thuhep" class="clearfix" style="width: 100%; display: none;">
                    <table id="chuyenhangNHOM" class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>TT</th>
                            <th>ĐL gửi</th>
                            <th>ĐL nhận</th>
                            <th>SL</th>
                            <th>Ngày chuyển</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th style="padding: 1px !important;">
                                <select style="width: 100% !important;" class="form-control input-sm search_daily_gui">
                                    <option value="">Tất cả đại lý</option>
                                    @foreach($chinhanhs as $item)
                                        <option value="{!! $item->ten_cn !!}">{!! $item->ten_cn !!}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th style="padding: 1px !important;">
                                <select style="width: 100% !important;" class="form-control input-sm search_daily_nhan">
                                    <option value="">Tất cả đại lý</option>
                                    @foreach($chinhanhs as $item)
                                        <option value="{!! $item->ten_cn !!}">{!! $item->ten_cn !!}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                    <table id="chuyenhangNHOM_chitiet" class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>TT</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>SL</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="morong" class="clearfix" style="width: 100%;">
                    <table id="chuyenhang" class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ĐL gửi</th>
                            <th>ĐL nhận</th>
                            <th>Mã SP</th>
                            <th>Tên SP</th>
                            <th>SL</th>
                            <th>Giá</th>
                            <th>Giá KM</th>
                            <th>Ngày tạo</th>
                            <th>Ngày chuyển</th>
                            <th>Trạng thái</th>
                            <th>Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody id="bangchuyenhang"></tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th style="padding: 1px !important;">
                                <select id="search_daily_gui" class="form-control input-sm">
                                    <option value="">Tất cả đại lý</option>
                                    @foreach($chinhanhs as $item)
                                        <option value="{!! $item->ten_cn !!}">{!! $item->ten_cn !!}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th style="padding: 1px !important;">
                                <select id="search_daily_nhan" class="form-control input-sm">
                                    <option value="">Tất cả đại lý</option>
                                    @foreach($chinhanhs as $item)
                                        <option value="{!! $item->ten_cn !!}">{!! $item->ten_cn !!}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade modal_tonghop" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Tổng hợp theo đầu đơn giá</h4>
                </div>
                <div class="modal-body text-center">
                    <table class="table table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>TT</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                        </tr>
                        </thead>
                        <tbody id="bang_tonghop">

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
    <script>
        var chuyenhangs = [];
        var chuyenhangs_NHOM = [];
        var dailys = [];
        var table = null;
        var tableNHOM = null;
        var tableNHOM_chitiet = null;
        var dataSource = [];
        var CHEDO = 'MORONG';
        var dataColumn = [
            {data: 'id'},
            {data: 'ten_cn_gui'},
            {data: 'ten_cn_nhan'},
            {data: 'ma_sp'},
            {data: 'ten_sp'},
            {data: 'sl'},
            {data: 'gia_sp', render: $.fn.dataTable.render.number('.', ',', 0)},
            {data: 'giaKM_sp', render: $.fn.dataTable.render.number('.', ',', 0)},
            {data: 'ngaytao'},
            {data: 'ngaychuyen'},
            {data: 'trangthai'},
            {data: 'ghichu'}
        ];
        var dataColumn_NHOM = [
            {data: 'tt'},
            {data: 'ten_daily_gui'},
            {data: 'ten_daily_nhan'},
            {data: 'sl'},
            {data: 'ngaytao'}
        ];
        var dataColumn_NHOM_chitiet = [
            {data: 'tt'},
            {data: 'ma_sp'},
            {data: 'ten_sp'},
            {data: 'sl'},
            {data: 'giaKM_sp', render: $.fn.dataTable.render.number('.', ',', 0)},
            {data: 'thanhtien', render: $.fn.dataTable.render.number('.', ',', 0)}
        ];

        var khoangthoigian;


        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_sanpham_chuyenhangs !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                chuyenhangs = result;
                NProgress.done();
                NProgress.start();
                $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                    table: '{!! \App\CusstomPHP\Tables::$tb_chinhanhs !!}',
                    _token: '{!! csrf_token() !!}'
                }, function (result) {
                    chinhanhs = result;
                    //Tải nhóm
                    $.ajax({
                        method: 'GET',
                        url: '{!! \App\CusstomPHP\CustomURL::route('nhomlichsuchuyenhan-ajax') !!}',
                        data: {
                            _token: '{!! csrf_token() !!}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            chuyenhangs_NHOM = result;
                            NProgress.done();
                            var batdau = moment(batdau_default, 'DD/MM/YYYY');
                            var ketthuc = moment(ketthuc_default, 'DD/MM/YYYY');
                            hienthi(batdau, ketthuc);
                        },
                        error: function () {
                            if (confirm("Tải dữ liệu bị lỗi!\nBạn có muốn tải lại?")) {
                                taiDulieu();
                            } else {
                                location.reload()
                            }
                        },
                        progress: function (e) {
                            if (e.lengthComputable) {
                                NProgress.set(e.loaded / e.total);
                            }
                        }
                    });
                }).error(function () {
                    NProgress.done();
                })
            }).error(function () {
                NProgress.done();
            });
        }

        function hienthi(batdau, ketthuc) {
            dataSource = [];
            var html = '';
            var ngaytao;
            var tt = 0;
            var sanpham_CH;
            var ten_cn_nhan = '';
            var ten_cn_gui = '';
            NProgress.start();
            //Chuyển hàng
            for (var i = 0; i < chuyenhangs.length; i++) {
                ngaytao = moment(chuyenhangs[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {

                    for (var j = 0; j < chinhanhs.length; j++) {
                        if (chuyenhangs[i]['daily_gui'] == chinhanhs[j]['ma_cn']) {
                            ten_cn_gui = chinhanhs[j]['ten_cn'];
                        }
                        if (chuyenhangs[i]['daily_nhan'] == chinhanhs[j]['ma_cn']) {
                            ten_cn_nhan = chinhanhs[j]['ten_cn'];
                        }
                    }
                    if ($('#search_daily_nhan').val() == ten_cn_nhan || $('#search_daily_nhan').val() == '') {
                        if ($('#search_daily_gui').val() == ten_cn_gui || $('#search_daily_gui').val() == '') {
                            //Chuyển đại lí
                            dataSource[tt] = [];
                            dataSource[tt]['ten_cn_gui'] = ten_cn_gui;
                            dataSource[tt]['ten_cn_nhan'] = ten_cn_nhan;
                            dataSource[tt]['id'] = chuyenhangs[i]['id'];
                            sanpham_CH = JSON.parse(chuyenhangs[i]['sanpham']);
                            dataSource[tt]['ma_sp'] = sanpham_CH['ma_sp'];
                            dataSource[tt]['ten_sp'] = sanpham_CH['ten_sp'];
                            dataSource[tt]['gia_sp'] = sanpham_CH['gia_sp'];
                            dataSource[tt]['giaKM_sp'] = sanpham_CH['giaKM_sp'];
                            dataSource[tt]['sl'] = chuyenhangs[i]['sl'];
                            dataSource[tt]['ngaytao'] = moment(chuyenhangs[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                            dataSource[tt]['ngaychuyen'] = chuyenhangs[i]['ngaytao'];
                            dataSource[tt]['ghichu'] = chuyenhangs[i]['ghichu'];
                            if (chuyenhangs[i]['trangthai'] == '{!! \App\CusstomPHP\State::$tt_Hoantat !!}') {
                                dataSource[tt]['trangthai'] = "{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Hoantat) !!}";
                            } else {
                                dataSource[tt]['trangthai'] = "{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_DaKhoiPhuc) !!}";
                            }
                            tt++;
                        }
                    }
                }
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            table = khoitaobangDATA_GROUP('chuyenhang', dataSource, dataColumn, 12, 8);
            NProgress.done();
            table.on('search.dt', function () {
                tongGT(5, 'chuyenhang');
                tongGT(6, 'chuyenhang');
                tongGT(7, 'chuyenhang');
            });
            tongGT(5, 'chuyenhang');
            tongGT(6, 'chuyenhang');
            tongGT(7, 'chuyenhang');

            //Chuyển hàng theo nhóm
            dataSource = [];
            tt = 0;
            for (i = 0; i < chuyenhangs_NHOM.length; i++) {
                ngaytao = moment(chuyenhangs_NHOM[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {

                    for (j = 0; j < chinhanhs.length; j++) {
                        if (chuyenhangs_NHOM[i]['daily_gui'] == chinhanhs[j]['ma_cn']) {
                            ten_cn_gui = chinhanhs[j]['ten_cn'];
                        }
                        if (chuyenhangs_NHOM[i]['daily_nhan'] == chinhanhs[j]['ma_cn']) {
                            ten_cn_nhan = chinhanhs[j]['ten_cn'];
                        }
                    }
                    if ($('.search_daily_nhan').val() == ten_cn_nhan || $('.search_daily_nhan').val() == '') {
                        if ($('.search_daily_gui').val() == ten_cn_gui || $('.search_daily_gui').val() == '') {
                            //Chuyển đại lí
                            dataSource[tt] = [];
                            dataSource[tt]['tt'] = tt;
                            dataSource[tt]['ten_daily_gui'] = ten_cn_gui;
                            dataSource[tt]['ten_daily_nhan'] = ten_cn_nhan;
                            dataSource[tt]['daily_gui'] = chuyenhangs_NHOM[i]['daily_gui'];
                            dataSource[tt]['daily_nhan'] = chuyenhangs_NHOM[i]['daily_nhan'];
                            dataSource[tt]['sl'] = chuyenhangs_NHOM[i]['TONGSL_SP'];
                            dataSource[tt]['ngaytao'] = chuyenhangs_NHOM[i]['ngaytao'];
                            tt++;
                        }
                    }
                }
            }
            if (tableNHOM != null) {
                tableNHOM.clear();
                tableNHOM.destroy();
            }
            tableNHOM = $("#chuyenhangNHOM").DataTable({
                data: dataSource,
                columns: dataColumn_NHOM,
                select: true,
                pageLength: 15,
                order: [[0, "desc"]],
                "searching": false,
                "bLengthChange": false
            });
            dataSource = [];
            //Hiển thị chitet
            if (tableNHOM_chitiet != null) {
                tableNHOM_chitiet.clear();
                tableNHOM_chitiet.destroy();
            }
            tableNHOM_chitiet = $("#chuyenhangNHOM_chitiet").DataTable({
                data: dataSource,
                columns: dataColumn_NHOM_chitiet,
                select: true,
                pageLength: 15,
                order: [[0, "desc"]],
                "searching": false,
                "bLengthChange": false
            });
            kiemtraquanli();
        }

        $('.search_daily_gui').change(function () {
            var batdau = $('#khoangthoigian').data('daterangepicker').startDate;
            var ketthuc = $('#khoangthoigian').data('daterangepicker').endDate;
            hienthi(batdau, ketthuc);
        });
        $('.search_daily_nhan').change(function () {
            var batdau = moment(batdau_default, 'DD/MM/YYYY');
            var ketthuc = moment(ketthuc_default, 'DD/MM/YYYY');
            hienthi(batdau, ketthuc);
        });

        function khoiphucCHUYEN(id) {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('khoiphuc-chuyenhang') !!}', {
                _token: '{!! csrf_token() !!}',
                id: id
            }, function (result) {
                if (result['success']) {
                    $.notify('Khôi phục chuyển hàng thành công!', 'success');
                    NProgress.done();
                } else {
                    $.notify('Khôi phục chuyển hàng lỗi!', 'error');
                    NProgress.done();
                }
            }).error(function () {
                $.notify('Lỗi kết nối tới server!', 'error');
                NProgress.done();
            });
        }
        //////////////////////////////////////////////
        var batdau_default = moment();
        var ketthuc_default = moment();
        $(document).ready(function () {
            taiDulieu();
            var start = moment().subtract(29, 'days');
            var end = moment();
            batdau_default = start.format('DD/MM/YYYY');
            ketthuc_default = end.format('DD/MM/YYYY');

            function cb(start, end) {
                $('#khoangthoigian').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }

            khoangthoigian = $('#khoangthoigian').daterangepicker({
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
        //Nhấn nút khôi phục chuyển
        $('#btn_khoiphuc').click(function () {
            if(CHEDO=='MORONG'){
                var data = table.rows({selected: true}).data();
                if (!confirm("Bạn có chắc muốn khôi phục " + data.length + " chuyển hàng này?")) {
                    return;
                }
                for (var i = 0; i < data.length; i++) {
                    if (data[i]['trangthai'] != '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_DaKhoiPhuc) !!}') {
                        khoiphucCHUYEN(data[i]['id']);
                    }
                }
                taiDulieu();
            }else{
                alert('Không thể khôi phục trong chế độ xem này!');
            }
        });
        //Tổng hợp
        var daugia = {};
        function tonghop(bang) {
            daugia = {};
            var chuyenhangs_TH;
            if (bang == 'chuyenhang') {
                chuyenhangs_TH = table.rows({search: 'applied'}).data();
            }
            if (bang == 'chuyenhangNHOM_chitiet') {
                chuyenhangs_TH = tableNHOM_chitiet.rows({search: 'applied'}).data();
            }
            for (var i = 0; i < chuyenhangs_TH.length; i++) {
                if (daugia[chuyenhangs_TH[i]['giaKM_sp']] == undefined) {
                    daugia[chuyenhangs_TH[i]['giaKM_sp']] = parseInt(chuyenhangs_TH[i]['sl']);
                } else {
                    daugia[chuyenhangs_TH[i]['giaKM_sp']] = parseInt(daugia[chuyenhangs_TH[i]['giaKM_sp']]) + parseInt(chuyenhangs_TH[i]['sl']);
                }
            }
            //Hiển thị lên modal
            var html = '';
            var tt = 0;
            var tong_gia = 0;
            var tong_sl = 0;
            for (i in daugia) {
                html += "<tr>";
                html += "<td>" + tt + "</td>";
                html += "<td>" + dinhdangNUMBER(i) + "</td>";
                html += "<td>" + daugia[i] + "</td>";
                html += "</tr>";
                tt++;
                tong_gia += parseInt(i) * parseInt(daugia[i]);
                tong_sl += parseInt(daugia[i]);
            }
            html += "<tr class='bg-info'><td></td><td>" + dinhdangNUMBER(tong_gia) + "</td><td>" + tong_sl + "</td></tr>";
            $('#bang_tonghop').html(html);
            $('.modal_tonghop').modal('show');
        }
        $('#btn_tonghop').click(function () {
            if (CHEDO == 'MORONG') {
                tonghop('chuyenhang');
            }
            if (CHEDO == 'THUHEP') {
                tonghop('chuyenhangNHOM_chitiet');
            }
        });
        $('#btn_morong').click(function () {
            if (CHEDO == 'MORONG') {
                CHEDO = 'THUHEP';
                $(this).html("<i class='fa fa-expand'></i> Xem chi tiết");
                $('#thuhep').show();
                $('#morong').hide();
            } else {
                if (CHEDO == 'THUHEP') {
                    CHEDO = 'MORONG';
                    $(this).html("<i class='fa fa-compress'></i> Nhóm chuyển hàng");
                    $('#thuhep').hide();
                    $('#morong').show();
                }
            }
        });
        //Tính tổng giá trị bảng được chọn
        function tongGT(cot, tenbang) {
            var tong = 0;
            if (cot > 5) {
                var SLs = table.column(5, {search: 'applied'}).data();
                var GIAs = table.column(cot, {search: 'applied'}).data();
                for (var jj = 0; jj < SLs.length; jj++) {
                    tong += SLs[jj] * GIAs[jj];
                }
            } else {
                table.column(cot, {search: 'applied'}).data().each(function (value, index) {
                    try {
                        tong += parseInt(value);
                    } catch (ex) {
                    }
                });
            }
            $('#' + tenbang).find('> tfoot > tr > th:nth-child(' + (parseInt(cot) + 1) + ')').text(dinhdangNUMBER(tong));
        }

        //Tính tổng giá trị bảng được chọn
        function tongGT_NHOM(cot, tenbang) {
            var tong = 0;
            tableNHOM_chitiet.column(cot, {search: 'applied'}).data().each(function (value, index) {
                try {
                    tong += parseInt(value);
                } catch (ex) {
                }
            });
            $('#' + tenbang).find('> tfoot > tr > th:nth-child(' + (parseInt(cot) + 1) + ')').text(dinhdangNUMBER(tong));
        }
        ////////////////////////////////////////////////////////////////
        $('#chuyenhangNHOM').find('tbody').on('click', 'tr', function () {
            setTimeout(function () {
                var data_selected = tableNHOM.rows('.selected').data();
                dataSource = [];
                var sanpham_CH;
                var tt = 0;
                for (var k = 0; k < data_selected.length; k++) {
                    for (var i = 0; i < chuyenhangs.length; i++) {
                        if (data_selected[k]['daily_gui'] == chuyenhangs[i]['daily_gui']) {
                            if (data_selected[k]['daily_nhan'] == chuyenhangs[i]['daily_nhan']) {
                                if (data_selected[k]['ngaytao'] == chuyenhangs[i]['ngaytao']) {
                                    //Chuyển đại lí
                                    dataSource[tt] = [];
                                    sanpham_CH = JSON.parse(chuyenhangs[i]['sanpham']);
                                    dataSource[tt]['tt'] = tt;
                                    dataSource[tt]['ma_sp'] = sanpham_CH['ma_sp'];
                                    dataSource[tt]['ten_sp'] = sanpham_CH['ten_sp'];
                                    dataSource[tt]['giaKM_sp'] = sanpham_CH['giaKM_sp'];
                                    dataSource[tt]['sl'] = chuyenhangs[i]['sl'];
                                    dataSource[tt]['thanhtien'] = parseInt(sanpham_CH['giaKM_sp']) * parseInt(chuyenhangs[i]['sl']);
                                    tt++;
                                }
                            }
                        }
                    }
                }
                if (tableNHOM_chitiet != null) {
                    tableNHOM_chitiet.clear();
                    tableNHOM_chitiet.destroy();
                }
                tableNHOM_chitiet = $("#chuyenhangNHOM_chitiet").DataTable({
                    data: dataSource,
                    columns: dataColumn_NHOM_chitiet,
                    select: true,
                    pageLength: 15,
                    order: [[0, "desc"]],
                    "searching": false,
                    "bLengthChange": false
                });
                table.on('search.dt', function () {
                    tongGT_NHOM(3, 'chuyenhangNHOM_chitiet');
                    tongGT_NHOM(5, 'chuyenhangNHOM_chitiet');
                });
                tongGT_NHOM(3, 'chuyenhangNHOM_chitiet');
                tongGT_NHOM(5, 'chuyenhangNHOM_chitiet');
            }, 1)
        });
    </script>
@stop