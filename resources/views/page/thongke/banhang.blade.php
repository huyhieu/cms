@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Thông kê bán hàng
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <input id="khoangthoigian" class="pull-right form-control input-sm">
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-12">
                    <table id="thongke" class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>TT</th>
                            <th>Ngày hóa đơn</th>
                            <th>Tên chi nhánh</th>
                            <th>Tổng hàng bán</th>
                            <th>Tổng tiền hàng</th>
                            <th>Tổng tiền khách trả</th>
                            <th>Tổng thanh toán</th>
                            <th>Tổng voucher</th>
                        </tr>
                        </thead>
                    </table>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Tên chi nhánh</th>
                            <th>Tổng hàng bán</th>
                            <th>Tổng tiền hàng</th>
                            <th>Tổng tiền khách trả</th>
                            <th>Tổng thanh toán</th>
                            <th>Tổng voucher</th>
                        </tr>
                        </thead>
                        <tbody id="thongke_tong">

                        </tbody>
                    </table>
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
    {!! \App\CusstomPHP\AssetFile::js('datetime/moment.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('daterangepicker/daterangepicker.js') !!}

    <script type="text/javascript">
        var hoadons = [];
        var chinhanhs = [];
        var dataSource = [];
        var dataColumn = [
            {
                data: "tt"
            },
            {
                data: "ngaytao",
                render: $.fn.dataTable.render.moment('DD/MM/YYYY')
            },

            {
                data: "ten_cn"
            },
            {
                data: "SL_MUA"
            },
            {
                data: "tongtien_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "tongtienKhachTra_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "tongtienKM_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "tienVC_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            }
        ];
        var table = null;
        var table_RAW = '';

        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_chinhanhs !!}',
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'json',
                success: function (result) {
                    chinhanhs = result;
                    NProgress.done();
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
            NProgress.start();
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_hoadons !!}',
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'json',
                success: function (result) {
                    hoadons = result;
                    hienthi(batdau_default, ketthuc_default);
                    NProgress.done();
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
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_chinhanhs !!}',
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'json',
                success: function (result) {
                    chinhanhs = result;
                    NProgress.done();
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
        }
        //Hiển thị lên form
        var tong_cn={};
        function hienthi(batdau, ketthuc) {
            dataSource = [];
            tong_cn={};
            $('#thongke').html(table_RAW);
            var ngaytao;
            var tt;
            batdau = moment(batdau, 'DD/MM/YYYY');
            ketthuc = moment(ketthuc, 'DD/MM/YYYY');

            for (var dt = moment(batdau); dt<=ketthuc; dt.add(1, 'days')) {
                for (var j = 0; j < chinhanhs.length; j++) {
                    tt = dataSource.length;
                    dataSource[tt] = [];
                    dataSource[tt]['tt'] = tt;
                    dataSource[tt]['ten_cn'] = chinhanhs[j]['ten_cn'];
                    dataSource[tt]['ngaytao'] = dt.format('DD/MM/YYYY');
                    dataSource[tt]['tongtien_hd'] = 0;
                    dataSource[tt]['tienVC_hd'] = 0;
                    dataSource[tt]['tongtienKM_hd'] = 0;
                    dataSource[tt]['tongtienKhachTra_hd'] = 0;
                    dataSource[tt]['SL_MUA'] = 0;
                    for (var i = 0; i < hoadons.length; i++) {
                        ngaytao = moment(hoadons[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                        if ((hoadons[i]['daily_hd'] == chinhanhs[j]['ma_cn']) && (ngaytao == dt.format('DD/MM/YYYY'))) {
                            dataSource[tt]['tongtien_hd'] += parseInt(hoadons[i]['tongtien_hd']);
                            dataSource[tt]['tienVC_hd'] += parseInt(hoadons[i]['tienVC_hd']);
                            dataSource[tt]['tongtienKM_hd'] += parseInt(hoadons[i]['tongtienKM_hd']);
                            dataSource[tt]['tongtienKhachTra_hd'] += parseInt(hoadons[i]['tongtienKhachTra_hd']);
                            dataSource[tt]['SL_MUA'] += parseInt(Object.keys(JSON.parse(hoadons[i]['sanpham_muas'])).length);
                        }
                    }
                    //Tính tổng
                    if(tong_cn[chinhanhs[j]['ten_cn']]==null){
                        tong_cn[chinhanhs[j]['ten_cn']]={};
                        tong_cn[chinhanhs[j]['ten_cn']]['tongtien_hd']=0;
                        tong_cn[chinhanhs[j]['ten_cn']]['tienVC_hd']=0;
                        tong_cn[chinhanhs[j]['ten_cn']]['tongtienKM_hd']=0;
                        tong_cn[chinhanhs[j]['ten_cn']]['tongtienKhachTra_hd']=0;
                        tong_cn[chinhanhs[j]['ten_cn']]['SL_MUA']=0;
                    }
                    tong_cn[chinhanhs[j]['ten_cn']]['tongtien_hd']+=parseInt(dataSource[tt]['tongtien_hd']);
                    tong_cn[chinhanhs[j]['ten_cn']]['tienVC_hd']+=parseInt(dataSource[tt]['tienVC_hd']);
                    tong_cn[chinhanhs[j]['ten_cn']]['tongtienKM_hd']+=parseInt(dataSource[tt]['tongtienKM_hd']);
                    tong_cn[chinhanhs[j]['ten_cn']]['tongtienKhachTra_hd']+=parseInt(dataSource[tt]['tongtienKhachTra_hd']);
                    tong_cn[chinhanhs[j]['ten_cn']]['SL_MUA']+=parseInt(dataSource[tt]['SL_MUA']);
                }
            }

            if (table != null) {
                table.clear();
                table.destroy();
            }
            table = khoitaobangDATA_GROUP('thongke', dataSource, dataColumn, 8, 1);
            //Hiển thị tổng
            var html='';
            for(var item in tong_cn){
                html+="<tr>";
                html+="<td>"+item+"</td>";
                html+="<td>"+tong_cn[item]['SL_MUA']+"</td>";
                html+="<td class='tien'>"+tong_cn[item]['tongtien_hd']+"</td>";
                html+="<td class='tien'>"+tong_cn[item]['tongtienKhachTra_hd']+"</td>";
                html+="<td class='tien'>"+tong_cn[item]['tongtienKM_hd']+"</td>";
                html+="<td class='tien'>"+tong_cn[item]['tienVC_hd']+"</td>";
                html+="</tr>";
            }
            $('#thongke_tong').html(html);
            reloadTien();
        }


        var batdau_default = moment();
        var ketthuc_default = moment();
        $(document).ready(function () {
            taiDulieu();
            table_RAW = $('#thongke').html();
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
            hienthi(batdau, ketthuc);
        });
        //Lọc sản phẩm
        $('#search_daily').change(function () {
            table.column(3).search($(this).val()).draw();
        });
    </script>
@stop