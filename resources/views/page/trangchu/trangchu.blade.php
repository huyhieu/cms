@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-sm-12" role="main">
        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Khách hàng</span>

                <div class="count">{!! count($khachhangs) !!}</div>
                <span class="count_bottom"><i class="green">4% </i> Trong tháng trước</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> Hóa đơn</span>

                <div class="count">{!! count($hoadons) !!}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3%
                    </i> Trong tháng trước</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Sản phẩm</span>

                <div class="count green">{!! count($sanphams) !!}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34%
                    </i> Trong tháng trước</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Giá trị hàng</span>

                <div class="count">{!! number_format($giatrihang/1000000) !!}</div>
                <span class="count_bottom"><i class="red">000,000 VNĐ</i> tiền hàng</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Giá trị voucher</span>

                <div class="count">{!! number_format($giatrivoucher,1) !!}</div>
                <span class="count_bottom"><i class="green">
                        {!! \App\CusstomPHP\Tables::getValue('donvi_diem',\App\CusstomPHP\Tables::$tb_khachhang_cauhinhs) !!}
                    </i> VNĐ giá quy đổi</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Tương tác hệ thống</span>

                <div class="count red">{!! count($tuongtac) !!}</div>
                <span class="count_bottom"><i class="green">0%
                    </i> Phát hiện lỗi</span>
            </div>
        </div>
        <!-- /top tiles -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="dashboard_graph">

                    <div class="row x_title">
                        <div class="col-md-12">
                            <h3>Thông tin chung
                                <small></small>
                            </h3>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <canvas id="bieudobanhang" width="400" height="100"></canvas>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
        <br>

        <div class="row">


            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel tile fixed_height_320 widget-custom-padding">
                    <div class="x_title">
                        <h2>Hàng tại các đại lý</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="bieudo_hangdaily" width="100" height="80"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel tile fixed_height_320 overflow_hidden widget-custom-padding">
                    <div class="x_title">
                        <h2>Loại sản phẩm</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="bieudo_loaisp" width="100" height="80"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel tile fixed_height_320 widget-custom-padding">
                    <div class="x_title">
                        <h2>Hóa đơn mới nhất</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Giá trị</th>
                                <th>Thời gian</th>
                            </tr>
                            </thead>
                            <tbody id="hienthihoadonmoi">
                            <tr class="text-center">
                                <td colspan="3">Chưa có hóa đơn mới!</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    </div>

@stop

@section('script')
    {!! \App\CusstomPHP\AssetFile::js('Chart/Chart.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datetime/moment.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datetime/moment-with-locales.min.js') !!}

    <script>
        var hoadons = [];
        var sanphams = [];
        var ctx = $('#bieudobanhang');

        function taiDulieu() {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_hoadons !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                hoadons = result;
                hienthi();
            }).error(function () {
                NProgress.done();
            })
        }

        var dataHD = [];
        var dataSP = [];
        var item = [];
        var dateNow = moment();
        //Hiển thị hóa đơn mới nhất
        $(document).ready(function () {
            taiDulieu();
        });

        function hienthi() {
            var htmlx = '';
            for (var j = hoadons.length - 1; j > hoadons.length - 7; j--) {
                if (hoadons[j]) {
                    htmlx += '<tr>';
                    htmlx += "<td>" + hoadons[j]['ma_hd'] + "</td>";
                    htmlx += "<td class='tien'>" + hoadons[j]['tongtienKM_hd'] + "</td>";
                    htmlx += "<td>" + hoadons[j]['ngaytao'] + "</td>";
                    htmlx += '</tr>';
                }
            }
            $('#hienthihoadonmoi').html(htmlx);
            reloadTien();
            htmlx = '';
            //Hóa đơn
            for ( day = 1; day <= 31; day++) {
                item = {
                    x: day,
                    y: 0
                };
                dataHD[day] = item;
            }
            for (var i = 0; i < hoadons.length; i++) {
                //Tính toán
                var date = moment(hoadons[i]['ngaytao'], 'HH:mm DD/MM/YYYY');
                for (var day = 1; day <= 31; day++) {
                    if (date.date() == day && date.month() == moment().get('month') && date.year() == moment().get('year')) {
                        dataHD[day]['y']=parseInt(dataHD[day]['y'])+1;
                    }
                }
            }
            var dataChart = {
                datasets: [{
                    label: 'Hóa đơn',
                    data: dataHD
                }]
            };
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: dataChart,
                options: {
                    backgroundColor: 'rgb(62, 178, 97)',
                    scales: {
                        xAxes: [{
                            type: 'linear',
                            position: 'bottom'
                        }]
                    }
                }
            });
            ///////////////////////////
            //Biểu đồ phân loại hàng
            var myPieChart = new Chart($('#bieudo_loaisp'), {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: "Phân loại theo kiểu",
                            borderWidth: 1,
                            backgroundColor: 'rgb(62, 178, 97)',
                            data: []
                        }
                    ]
                }
            });
            //Biểu đồ chi nhánh
            var myPieChartChinhanh = new Chart($('#bieudo_hangdaily'), {
                type: 'bar',
                data: {
                    labels: [<?php $sl_chinhanh=count($chinhanhs);$sl_hientai=0;  foreach($chinhanhs as $item){$sl_hientai++; if($sl_hientai!=$sl_chinhanh){echo "'".$item->ma_cn."',";}else{echo "'".$item->ma_cn."'";}}   ?>],
                    datasets: [
                        {
                            label: "Phân loại theo chi nhánh",
                            borderWidth: 1,
                            backgroundColor: 'rgb(80, 117, 178)',
                            data: [<?php $sl_chinhanh=count($chinhanhs);$sl_hientai=0;  foreach($chinhanhs as $item){$tongsp=0;$sl_hientai++;foreach ($sanphams as $sp) {if ($sp->daily_sp == $item->ma_cn) {$tongsp = intval($tongsp) + 1;}} if($sl_hientai!=$sl_chinhanh){echo $tongsp.',';}else{echo $tongsp;}}   ?>]
                        }
                    ]
                }
            });
        }
    </script>
@stop