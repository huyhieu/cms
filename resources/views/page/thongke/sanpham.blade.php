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
                <div class="col-sm-4">
                    <label>Thông tin chung:</label>
                    <table class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>Thông tin</th>
                            <th>Giá trị</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Tổng tiền hàng trong kho:</td>
                            <td><b id="tongtienhang" class="tien">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền hàng (giá Khuyến mãi):</td>
                            <td><b id="tongtienhang_KM" class="tien">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng lượng hàng trong kho:</td>
                            <td><b id="tongluonghang">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền hàng đã nhập:</td>
                            <td><b id="tongtiennhap" class="tien">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng lượng hàng đã nhập:</td>
                            <td><b id="tongluongnhap">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền hàng hóa đơn:</td>
                            <td><b id="tongtienhoadon" class="tien">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng lượng hàng hóa đơn:</td>
                            <td><b id="tongluonghoadon">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Dự kiến lãi (nếu thanh toán đầy đủ):</td>
                            <td><b id="tongtienlai" class="tien">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền dư nợ:</td>
                            <td><b id="tongno" class="tien">Đang tính...</b></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền lãi (đã trừ khách nợ):</td>
                            <td><b id="laichuan" class="tien">Đang tính...</b></td>
                        </tr>
                        </tbody>
                    </table>

                    <div id="thongtinspban">
                        <label>Sản phẩm đã bán:</label>
                        <table class="table table-striped table-bordered jambo_table">
                            <thead>
                            <tr>
                                <th>Mã</th>
                                <th>SL</th>
                                <th>ĐL</th>
                            </tr>
                            </thead>
                            <tbody id="hienthi_SP_daban"></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-8 haibang">
                    <label>Danh sách hóa đơn:</label>
                    <table class="table  table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã HĐ</th>
                            <th>Tên khách hàng</th>
                            <th>Đại lý</th>
                            <th>Tổng tiền</th>
                            <th>Tổng trả</th>
                            <th>Tiền khách trả</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody id="danhsachhoadon"></tbody>
                    </table>
                    <hr>
                    <label>Sản phẩm đã nhập:</label>
                    <table id="table_nhaphang" class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>SL</th>
                            <th>Giá</th>
                            <th>Ngày tạo</th>
                        </tr>
                        </thead>
                        <tbody id="sanpham_danhap"></tbody>
                    </table>
                    <hr>
                </div>

            </div>
        </div>
    </div>

@stop


@section('script')
    {{--DataTable--}}
    {!! \App\CusstomPHP\AssetFile::js('datatable/jquery.dataTables.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.bootstrap.min.js') !!}

    {!! \App\CusstomPHP\AssetFile::js('datetime/moment.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('daterangepicker/daterangepicker.js') !!}

    <script type="text/javascript">
        var sanphams = [];
        var hoadons = [];
        var nhaphangs = [];

        var table_nhaphang=null;

        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_sanphams !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                sanphams = result;
                NProgress.done();
                //Load hóa đơn
                NProgress.start();
                $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                    table: '{!! \App\CusstomPHP\Tables::$tb_hoadons !!}',
                    _token: '{!! csrf_token() !!}'
                }, function (result) {
                    hoadons = result;
                    NProgress.done();
                    //Load nhập hàng
                    NProgress.start();
                    $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                        table: '{!! \App\CusstomPHP\Tables::$tb_sanpham_nhaphangs !!}',
                        _token: '{!! csrf_token() !!}'
                    }, function (result) {
                        nhaphangs = result;
                        NProgress.done();
                        //Load lên menu
                        hienthi();
                    }).error(function () {
                        NProgress.done();
                    });
                }).error(function () {
                    NProgress.done();
                });
            }).error(function () {
                NProgress.done();
            })
        }
        //Hiển thị lên form
        function hienthi() {
            table = $('.bang').DataTable();
            reloadTien();
            hienthiByDate(batdau_default, ketthuc_default);
        }

        function hienthiByDate(batdau, ketthuc) {
            hienthi_SP_daban(batdau,ketthuc);
            batdau = moment(batdau, 'DD/MM/YYYY');
            ketthuc = moment(ketthuc, 'DD/MM/YYYY');
            var html='';
            var tongtienhang = 0;
            var tongtienhang_KM = 0;
            var tongluonghang = 0;
            var tongtiennhap = 0;
            var tongluongnhap = 0;
            var tongtienhoadon = 0;
            var tongluonghoadon = 0;
            var tongno = 0;
            var laichuan = 0;
            var ngaytao = moment();
            for (var i = 0; i < sanphams.length; i++) {
                ngaytao = moment(sanphams[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {

                    tongtienhang += parseInt(sanphams[i]['gia_sp']) * parseInt(sanphams[i]['SL_sp']);
                    tongtienhang_KM += parseInt(sanphams[i]['giaKM_sp']) * parseInt(sanphams[i]['SL_sp']);
                    tongluonghang += parseInt(sanphams[i]['SL_sp']);
                }

            }
            for (var j = 0; j < nhaphangs.length; j++) {
                ngaytao = moment(nhaphangs[j]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {
                    tongtiennhap += parseInt(nhaphangs[j]['gia_nhap']) * parseInt(nhaphangs[j]['sl_nhap']);
                    tongluongnhap += parseInt(nhaphangs[j]['sl_nhap']);
                    
                    html += "<tr>";
                    html += "<td>" + nhaphangs[j]['id'] + "</td>";
                    html += "<td>" + nhaphangs[j]['ma_sp'] + "</td>";
                    html += "<td>" + nhaphangs[j]['ten_sp'] + "</td>";
                    html += "<td>" + nhaphangs[j]['sl_nhap'] + "</td>";
                    html += "<td class='tien'>" + nhaphangs[j]['gia_nhap'] + "</td>";
                    html += "<td>" + nhaphangs[j]['ngaytao'] + "</td>";
                    html += "</tr>";
                }
            }

            if(table_nhaphang!=null){
                table_nhaphang.fnClearTable();
                table_nhaphang.fnDestroy();
            }
            $('#sanpham_danhap').html(html);
            table_nhaphang=$('#table_nhaphang').dataTable();
            html='';

            for(var k=0;k<hoadons.length;k++){
                ngaytao = moment(hoadons[k]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {
                    tongtienhoadon+=parseInt(hoadons[k]['tongtien_hd']);
                    tongluonghoadon++;
                    tongno+=parseInt(hoadons[k]['tongtienKM_hd'])-parseInt(hoadons[k]['tongtienKhachTra_hd']);
                    
                    html += "<tr title='" + hoadons[k]['id'] + "'>";
                    html += "<td>" + hoadons[k]['id'] + "</td>";
                    html += "<td>" + hoadons[k]['ma_hd'] + "</td>";
                    html += "<td>" + hoadons[k]['hoten_kh'] + "</td>";
                    html += "<td>" + hoadons[k]['daily_hd'] + "</td>";
                    html += "<td class='tien'>" + hoadons[k]['tongtien_hd'] + "</td>";
                    html += "<td class='tien'>" + hoadons[k]['tongtienKM_hd'] + "</td>";
                    html += "<td class='tien'>" + hoadons[k]['tongtienKhachTra_hd'] + "</td>";
                    if(hoadons[k]['trangthai']=='{!! \App\CusstomPHP\State::$tt_Nolai !!}'){
                        html += "<td>" + '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Nolai) !!}' + "</td>";
                    }else{
                        html += "<td>" + '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Hoantat) !!}' + "</td>";
                    }

                    html += "</tr>";
                }
            }
            $('#danhsachhoadon').html(html);
            html='';

            dukienlai(batdau,ketthuc);
            $('#laichuan').html(parseInt($('#tongtienlai').autoNumeric('get'))-parseInt(tongno));
            $('#tongno').html(tongno);
            $('#tongtienhang').html(tongtienhang);
            $('#tongtienhang_KM').html(tongtienhang_KM);
            $('#tongluonghang').html(tongluonghang);
            $('#tongtiennhap').html(tongtiennhap);
            $('#tongluongnhap').html(tongluongnhap);
            $('#tongtienhoadon').html(tongtienhoadon);
            $('#tongluonghoadon').html(tongluonghoadon);
            reloadTien();
        }

        function dukienlai(batdau, ketthuc){
            var ngaytao=moment();
            var danhsachhang;
            var tonggianhaphang=0;
            var tongthanhtoanhoadon=0;
            for(var k=0;k<hoadons.length;k++){
                ngaytao = moment(hoadons[k]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {
                    danhsachhang=JSON.parse(hoadons[k]['sanpham_muas']);
                    tongthanhtoanhoadon+=parseInt(hoadons[k]['tongtienKM_hd']);
                    for(var item in danhsachhang) {
                        for (var l = 0; l < sanphams.length; l++) {
                            if (danhsachhang[item]['id'] == sanphams[l]['id']) {
                                tonggianhaphang += parseInt(sanphams[l]['giaNHAP_sp'])*parseInt(danhsachhang[item]['SL_MUA']);
                            }
                        }
                    }
                }
            }
            var tonglai=tongthanhtoanhoadon-tonggianhaphang;
            $('#tongtienlai').html(tonglai);
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
            hienthiByDate(batdau, ketthuc);
        });

        //Hiển thị sản phẩm đã bán trong ngày
        function hienthi_SP_daban(batdau, ketthuc){
            var ngaytao;
            var sanphams_HD={};
            var sp;
            batdau = moment(batdau, 'DD/MM/YYYY');
            ketthuc = moment(ketthuc, 'DD/MM/YYYY');
            for(var i=0;i<hoadons.length;i++){
                ngaytao = moment(hoadons[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {
                    sp=JSON.parse(hoadons[i]['sanpham_muas']);
                    for(var j in sp){
                        if (typeof sanphams_HD[j] !== 'undefined') {
                            if(sanphams_HD[j]['daily_sp']==sp[j]['daily_sp']){
                                //console.log("Tồn tại"+sanphams_HD[j]['ma_sp']);
                                sanphams_HD[j]['SL_MUA']=(parseInt(sanphams_HD[j]['SL_MUA'])+ parseInt(sp[j]['SL_MUA']));
                            }else{

                                sanphams_HD[j]=sp[j];
                            }
                        }else{
                            console.log("Tồn tại"+sp[j]['ma_sp']+" "+j);
                            sanphams_HD[j]=sp[j];
                        }

                    }
                }
            }
            var html='';
            for(i in sanphams_HD){
                html+="<tr>";
                html+="<td>"+sanphams_HD[i]['ma_sp']+"</td>";
                html+="<td>"+sanphams_HD[i]['SL_MUA']+"</td>";
                html+="<td>"+sanphams_HD[i]['daily_sp']+"</td>";
                html+="</tr>";
            }
            $('#hienthi_SP_daban').html(html);
        }
    </script>
@stop