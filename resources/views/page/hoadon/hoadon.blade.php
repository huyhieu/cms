@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Hóa đơn
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
                    <li class="dropdown quanli">
                        <a id="sua" data-toggle="modal" data-target=".modal-hoadon" href="#"
                           class="btn btn-primary btn-sm disabled nut_khoa">
                            <i class="fa fa-h-square"></i>
                            Sửa hóa đơn
                        </a>
                    </li>
                    <li class="dropdown">
                        <a id="xem_hang" href="#" class="btn disabled nut_khoa btn-info btn-sm">
                            <i class="fa fa-street-view"></i>
                            Xem hàng hóa đơn
                        </a>
                    </li>
                    <li class="dropdown quanli">
                        <a id="xoa" href="#" class="btn disabled nut_khoa btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                            Xóa hóa đơn
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
                        <th>Tổng tiền</th>
                        <th>Voucher</th>
                        <th>Tổng trả</th>
                        <th>Khách trả</th>
                        <th>KM (%)</th>
                        <th>SL hàng</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody id="noidung_banghoadon">
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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

    {{--Modal--}}
    <div class="modal fade modal-hoadon" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="title-modal-sp">Sửa thông tin hóa đơn</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mã hóa đơn:</label>
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
                                <option value="{!! \App\CusstomPHP\State::$tt_Nolai !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Nolai) !!}</option>
                            </select>
                        </div>
                    </div>
                    <label>Ghi chú:</label>
                    <textarea id="ghichu" class="form-control nhap input-sm"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button id="suahoadon_save" type="button" class="btn btn-primary">Sửa hóa đơn</button>
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
                    <h4 class="modal-title">Xem sản phẩm trong hóa đơn</h4>
                </div>
                <div class="modal-body text-center">
                    <table class="table table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>TT</th>
                            <th>Mã hàng</th>
                            <th>Tên hàng</th>
                            <th>Giá hàng</th>
                            <th>Giá KM</th>
                            <th>SL mua</th>
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
                    <button id="luulaihanghoadon" type="button" class="btn btn-primary quanli">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section('script')
    <script>
        var hoadons = [];
        var table = null;
        var dataSource = [];
        var dataColumn = [
            {
                data: "id"
            },
            {
                data: "ma_hd"
            },
            {
                data: "hoten_kh"
            },
            {
                data: "daily_hd"
            },
            {
                data: "tongtien_hd"
                ,render: $.fn.dataTable.render.number('.', ',', 0)

            },
            {
                data: "tienVC_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "tongtienKM_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "tongtienKhachTra_hd",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "phantramKM_hd"
            },
            {
                data: "SL_MUA"
            },
            {
                data: "ngaytao"
            },
            {
                data: "ngaysua"
            },
            {
                data: "trangthai"
            },
            {
                data: "ghichu"
            }];
        var id_dangchon = '';

        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('ajax-all-hoadon-by-daily') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_hoadons !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                hoadons = result;
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
            var batdau = moment(batdau_default, 'DD/MM/YYYY');
            var ketthuc = moment(ketthuc_default, 'DD/MM/YYYY');
            hienthi(batdau, ketthuc);
        });

        //Load lên sửa hóa đơn
        $('#sua').click(function () {
            for (var i = 0; i < hoadons.length; i++) {
                if (hoadons[i]['id'] == id_dangchon) {
                    $('#daily_hd').val(hoadons[i]['daily_hd']);
                    $('#ma_hd').val(hoadons[i]['ma_hd']);
                    $('#id_kh').val(hoadons[i]['id_kh']);
                    $('#hoten_kh').val(hoadons[i]['hoten_kh']);
                    $('#tongtien_hd').autoNumeric('set', hoadons[i]['tongtien_hd']);
                    $('#tongtienKM_hd').autoNumeric('set', hoadons[i]['tongtienKM_hd']);
                    $('#tongtienKhachTra_hd').autoNumeric('set', hoadons[i]['tongtienKhachTra_hd']);
                    $('#trangthai').val(hoadons[i]['trangthai']);
                    $('#ghichu').val(hoadons[i]['ghichu']);
                }
            }
        });
        //Lưu hóa đơn lên server
        $('#suahoadon_save').click(function () {
            $.post('{!! \App\CusstomPHP\CustomURL::route('sua-hoadon') !!}', {
                id: id_dangchon,
                daily_hd: $('#daily_hd').val(),
                ma_hd: $('#ma_hd').val(),
                id_kh: $('#id_kh').val(),
                hoten_kh: $('#hoten_kh').val(),
                tongtien_hd: $('#tongtien_hd').autoNumeric('get'),
                tongtienKM_hd: $('#tongtienKM_hd').autoNumeric('get'),
                tongtienKhachTra_hd: $('#tongtienKhachTra_hd').autoNumeric('get'),
                trangthai: $('#trangthai').val(),
                ghichu: $('#ghichu').val(),
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Sửa hóa đơn thành công!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Sửa hóa đơn lỗi!", 'error');
                }
            });
        });
        //Xóa lên server
        $('#xoa').click(function () {
            if (confirm('Bạn có chắc muốn xóa hóa đơn này?')) {
                $.post('{!! \App\CusstomPHP\CustomURL::route('xoa-hoadon') !!}', {
                    id: id_dangchon,
                    _token: '{!! csrf_token() !!}'
                }, function (result) {
                    if (result['success']) {
                        $.notify("Xóa hóa đơn thành công!", 'success');
                        window.location.reload();
                    } else {
                        $.notify("Xóa hóa đơn lỗi!", 'error');
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
            $.get('{!! \App\CusstomPHP\CustomURL::route('getsp-hoadon') !!}', {
                id: id_dangchon,
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                hang_hoadon = result;
                id_hoadon_hienthi = id_dangchon;
                hienthiSPlenModal();
                $('.modal_xem_hang').modal('show');
                nut_xemhang.html("<i class='fa fa-street-view'></i> Xem hàng hóa đơn");
            })
        });
        //Hiển thị hàng lên modal_hoadon
        function hienthiSPlenModal() {
            var result = hang_hoadon;
            var html = '';
            var tt = 0;
            for (var i in result) {
                html += '<tr>';
                html += "<td>" + tt + "</td>";
                html += "<td>" + result[i]['ma_sp'] + "</td>";
                html += "<td>" + result[i]['ten_sp'] + "</td>";
                html += "<td>" + dinhdangNUMBER(result[i]['gia_sp']) + "</td>";
                html += "<td>" + dinhdangNUMBER(result[i]['giaKM_sp']) + "</td>";
                html += "<td>" + result[i]['SL_MUA'] + "</td>";
                html += "<td>" + dinhdangNUMBER(result[i]['Tong']) + "</td>";
                if (level_quanli) {
                    html += "<td><button onclick='xoaSPkhoihoadon(" + i + ")' class='btn btn-danger btn-xs'><i class='fa fa-reddit'></i> Nhập lại</button></td>";
                } else {
                    html += "<td></td>";

                }
                html += '</tr>';
                tt++;
            }
            $('#hienthihang_hd').html(html);
        }
        //Xóa hàng khỏi hóa đơn
        function xoaSPkhoihoadon(id) {
            delete hang_hoadon[id];
            hienthiSPlenModal();
        }
        //Lưu lại hàng lên server
        $('#luulaihanghoadon').click(function () {
            if (confirm("Bạn có chắc muốn lưu?\nTổng tiền hóa đơn sẽ không thay đổi. Bạn có thể thay đổi nó nếu muốn."))
                $.post('{!! \App\CusstomPHP\CustomURL::route('capnhathang-hoadon') !!}', {
                    _token: '{!! csrf_token() !!}',
                    sanpham_muas: JSON.stringify(hang_hoadon),
                    id: id_hoadon_hienthi
                }, function (result) {
                    if (result['success']) {
                        $.notify("Cập nhật hàng hóa đơn thành công!", 'success');
                    } else {
                        $.notify("Cập nhật hàng hóa đơn lỗi!", 'error');
                    }
                }).error(function () {
                    $.notify("Lỗi kết nối!", 'error');
                });
        });
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
            dataSource = [];
            var ngaytao;
            var tt = 0;
            var SP_mua=null;
            var SL_MUA_T=0;
            NProgress.start();
            for (var i = 0; i < hoadons.length; i++) {
                ngaytao = moment(hoadons[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                ngaytao = moment(ngaytao, 'DD/MM/YYYY');
                if (ngaytao >= batdau && ngaytao <= ketthuc) {
                    tt = dataSource.length;
                    if($('#search_daily').val()==hoadons[i]['daily_hd'] || $('#search_daily').val()==''){
                        dataSource[tt]=[];
                        dataSource[tt]['id'] = hoadons[i]['id'];
                        dataSource[tt]['ma_hd'] = hoadons[i]['ma_hd'];
                        dataSource[tt]['hoten_kh'] = hoadons[i]['hoten_kh'];
                        dataSource[tt]['daily_hd'] = hoadons[i]['daily_hd'];
                        dataSource[tt]['tongtien_hd'] = hoadons[i]['tongtien_hd'];
                        dataSource[tt]['tienVC_hd'] = hoadons[i]['tienVC_hd'];
                        dataSource[tt]['tongtienKM_hd'] = hoadons[i]['tongtienKM_hd'];
                        dataSource[tt]['tongtienKhachTra_hd'] = hoadons[i]['tongtienKhachTra_hd'];
                        dataSource[tt]['phantramKM_hd'] = hoadons[i]['phantramKM_hd'];
                        SP_mua=JSON.parse(hoadons[i]['sanpham_muas']);
                        SL_MUA_T=0;
                        for(var s in SP_mua){
                            SL_MUA_T+=parseInt(SP_mua[s]['SL_MUA']);
                        }
                        dataSource[tt]['SL_MUA'] = SL_MUA_T;
                        dataSource[tt]['ngaytao'] = moment(hoadons[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('HH:mm DD/MM');
                        dataSource[tt]['ngaysua'] = moment(hoadons[i]['ngaysua'], "HH:mm DD/MM/YYYY").format('HH:mm DD/MM');
                        if (hoadons[i]['trangthai'] == '{!! \App\CusstomPHP\State::$tt_Hoantat !!}') {
                            dataSource[tt]['trangthai'] = '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Hoantat) !!}';
                        } else {
                            dataSource[tt]['trangthai'] = '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Nolai) !!}';
                        }
                        dataSource[tt]['ghichu'] = hoadons[i]['ghichu'];
                    }
                }
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            table = khoitaobangDATA_GROUP('banghoadon', dataSource, dataColumn,14,10);
            NProgress.done();
            table.on( 'search.dt', function () {
                tongGT(4,'banghoadon');
                tongGT(5,'banghoadon');
                tongGT(6,'banghoadon');
                tongGT(7,'banghoadon');
                tongGT(9,'banghoadon');
            });
            tongGT(4,'banghoadon');
            tongGT(5,'banghoadon');
            tongGT(6,'banghoadon');
            tongGT(7,'banghoadon');
            tongGT(9,'banghoadon');
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
        function tongGT(cot,tenbang){
            var tong=0;
            table.column(cot, { search:'applied' } ).data().each(function(value, index) {
                try{
                    tong+=parseInt(value);
                }catch(ex){}
            });
            $('#'+tenbang).find('> tfoot > tr > th:nth-child('+(parseInt(cot)+1)+')').text(dinhdangNUMBER(tong));
        }

    </script>

@stop