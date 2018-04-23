@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Hóa đơn theo hàng hóa
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
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-12">
                    <table id="thongke" class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>Ngày hóa đơn</th>
                            <th>Mã hóa đơn</th>
                            <th>Tên đại lý</th>
                            <th>Mã ĐL</th>
                            <th>Tên khách hàng</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá SP</th>
                            <th>Giá mua</th>
                            <th>Giảm (%)</th>
                            <th>Số lượng</th>
                        </tr>
                        </thead>
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
        var dataSource=[];
        var dataColumn = [
            {
                data: "ngaytao"
            },
            {
                data: "ma_hd"
            },
            {
                data: "ten_daily_hd"
            },
            {
                data: "daily_hd"
            },
            {
                data: "hoten_kh"
            },
            {
                data: "ma_sp"
            },
            {
                data: "ten_sp"
            },
            {
                data: "gia_sp",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "giaKM_sp",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "giam_PT"
            },
            {
                data: "SL_MUA"
            }
        ];
        var table=null;

        //Tải dữ liệu trên mạng về
        function taiDulieu() {
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
                            hienthi(batdau_default, ketthuc_default);
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
        function hienthi(batdau, ketthuc) {
            dataSource=[];
            var ngaytao;
            var id;
            batdau = moment(batdau, 'DD/MM/YYYY');
            ketthuc = moment(ketthuc, 'DD/MM/YYYY');
            for(var i=0;i<hoadons.length;i++){
                ngaytao = moment(hoadons[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if(ngaytao >= batdau && ngaytao <= ketthuc){
                    if($('#search_daily').val()==hoadons[i]['daily_hd'] || $('#search_daily').val()==''){
                        var sanpham_muas=JSON.parse(hoadons[i]['sanpham_muas']);
                        for(var index in sanpham_muas){
                            id=dataSource.length;
                            dataSource[id]={};
                            dataSource[id]['ngaytao']=moment(hoadons[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                            dataSource[id]['ma_hd']=hoadons[i]['ma_hd'];
                            for(var cn=0;cn<chinhanhs.length;cn++){
                                if(hoadons[i]['daily_hd']==chinhanhs[cn]['ma_cn']){
                                    dataSource[id]['ten_daily_hd']=chinhanhs[cn]['ten_cn'];
                                }
                            }
                            dataSource[id]['daily_hd']=hoadons[i]['daily_hd'];
                            dataSource[id]['hoten_kh']=hoadons[i]['hoten_kh'];
                            dataSource[id]['ma_sp']=sanpham_muas[index]['ma_sp'];
                            dataSource[id]['ten_sp']=sanpham_muas[index]['ten_sp'];
                            dataSource[id]['gia_sp']=sanpham_muas[index]['gia_sp'];
                            dataSource[id]['giaKM_sp']=sanpham_muas[index]['giaKM_sp'];
                            dataSource[id]['giam_PT']=parseInt(100-parseFloat(sanpham_muas[index]['giaKM_sp'])/parseFloat(sanpham_muas[index]['gia_sp'])*100);
                            dataSource[id]['SL_MUA']=sanpham_muas[index]['SL_MUA'];
                        }
                    }
                }
            }
            if(table!=null){
                table.clear();
                table.destroy();
            }
            table=khoitaobangDATA_GROUP('thongke',dataSource,dataColumn,10,0);
        }


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
            hienthi(batdau, ketthuc);
        });
        //Lọc sản phẩm
        $('#search_daily').change(function () {
            var batdau = $('#khoangthoigian').data('daterangepicker').startDate;
            var ketthuc = $('#khoangthoigian').data('daterangepicker').endDate;
            hienthi(batdau, ketthuc);
        });
    </script>
@stop