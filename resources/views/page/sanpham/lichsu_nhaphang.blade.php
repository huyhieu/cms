@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Sản phẩm hiện hành
                    <small>Tất cả</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <input id="khoangthoigian" class="pull-right form-control input-sm">
                    </li>
                    <li class="dropdown">
                        <a onclick="location.reload();" href="#" class="btn btn-default btn-sm">
                            <i class="fa fa-refresh"></i>
                            Reload
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>

                <table id="nhaphang" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>SL</th>
                        <th>Giá nhập</th>
                        <th>Đại lí</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="bangnhaphang"></tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>0</th>
                        <th>0</th>
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
    {!! \App\CusstomPHP\AssetFile::js('datetime/moment.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('daterangepicker/daterangepicker.js') !!}
    <script>
        var nhaphangs = [];
        var table = null;

        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_sanpham_nhaphangs !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                nhaphangs = result;
                NProgress.done();
                //hienthi();
                var batdau = moment(batdau_default, 'DD/MM/YYYY');
                var ketthuc = moment(ketthuc_default, 'DD/MM/YYYY');
                hienthi(batdau, ketthuc);
            }).error(function () {
                NProgress.done();
            })
        }
        function hienthi(batdau, ketthuc) {
            var html = '';
            var ngaytao;

            NProgress.start();
            for (var i = 0; i < nhaphangs.length; i++) {
                if (parseInt(nhaphangs[i]['sl_nhap']) > 0) {
                    ngaytao = moment(nhaphangs[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                    ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                    if (ngaytao >= batdau && ngaytao <= ketthuc) {
                        html += '<tr>';
                        html += "<td>" + nhaphangs[i]['id'] + "</td>";
                        html += "<td>" + nhaphangs[i]['ma_sp'] + "</td>";
                        html += "<td>" + nhaphangs[i]['ten_sp'] + "</td>";
                        html += "<td>" + nhaphangs[i]['sl_nhap'] + "</td>";
                        html += "<td>" + dinhdangNUMBER(nhaphangs[i]['gia_nhap']) + "</td>";
                        html += "<td>" + 'KHO' + "</td>";
                        html += "<td>" + nhaphangs[i]['ngaytao'] + "</td>";
                        if (nhaphangs[i]['trangthai'] == '{!! \App\CusstomPHP\State::$tt_Hoantat !!}') {
                            html += "<td>{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Hoantat) !!}</td>";
                        } else {
                            html += "<td>{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_VoHieuHoa) !!}</td>";
                        }
                        html += "<td>" + nhaphangs[i]['ghichu'] + "</td>";
                        html += "<td><button onclick='xoa(" + nhaphangs[i]['id'] + ")' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Xóa</button></td>";
                        html += '</tr>';
                    }
                }
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            $('#bangnhaphang').html(html);
            table = khoitaobang('nhaphang');
            table.on('search.dt', function () {
                tongGT();
            });
            tongGT();
            reloadTien();
            NProgress.done();
        }

        function xoa(id) {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('delete-nhaphang') !!}', {
                _token: '{!! csrf_token() !!}',
                id: id
            }, function (result) {
                if (result['success']) {
                    $.notify('Xóa nhập hàng thành công!', 'success');
                    taiDulieu();
                    NProgress.done();
                } else {
                    $.notify('Xóa nhập hàng lỗi!', 'error');
                    NProgress.done();
                }
            }).error(function () {
                $.notify('Lỗi kết nối tới server!', 'error');
                NProgress.done();
            });
        }
        /////////////////////////////////////////////////////////////////////////////////////
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

        //Tính tổng giá trị bảng được chọn
        function tongGT() {
            var tongSL = 0;
            var tongTien = 0;
            var SLs = table.column(3, {search: 'applied'}).data();
            var GIAs = table.column(4, {search: 'applied'}).data();
            for (var jj = 0; jj < SLs.length; jj++) {
                GIAs[jj]=GIAs[jj].replace('.','');
                tongTien += parseInt(SLs[jj]) * parseInt(GIAs[jj]);
                tongSL += parseInt(SLs[jj]);

                $('#nhaphang').find('> tfoot > tr > th:nth-child(' + (parseInt(4)) + ')').text(dinhdangNUMBER(tongSL));
                $('#nhaphang').find('> tfoot > tr > th:nth-child(' + (parseInt(5)) + ')').text(dinhdangNUMBER(tongTien));
            }
        }
    </script>
@stop