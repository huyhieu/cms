@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Chuyển hàng tại các đại lý
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <select id="search_daily" class="form-control input-sm">
                            <option value="">Tất cả đại lý</option>
                            @foreach($chinhanhs as $item)
                                @if(\App\CusstomPHP\CurrentUser::user()->daily==$item->ma_cn)
                                    <option selected value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                                @else
                                    <option value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                                @endif
                            @endforeach
                        </select>
                    </li>
                    <li class="dropdown">
                        <a id="chuyen" href="#"
                           class="btn btn-primary btn-sm">
                            <i class="fa fa-cloud-upload"></i>
                            Chuyển hàng
                        </a>
                    </li>
                    <li class="dropdown">
                        <a onclick="taiDuLieu();"  href="#"
                           class="btn btn-default btn-sm">
                            <i class="fa fa-refresh"></i>
                            Reload
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-6 haibang">
                    <label>Đại lí gửi:</label>
                    <table id="bangchuyenhang"
                           data-toggle="tooltip" data-placement="top" title="" data-original-title="Click vào hàng để chọn"
                           class="table bang table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>SL</th>
                            <th>Giá</th>
                            <th>Đại lý</th>
                        </tr>
                        </thead>
                        <tbody id="hanggui"></tbody>
                    </table>
                </div>
                <div class="col-sm-6 haibang">
                    <label>Đại lí nhận:</label>
                    <select id="daily_nhan" class="form-control input-sm" style="margin-bottom: 10px">
                        <option value="">Chọn đại lí nhận hàng</option>
                        @foreach($chinhanhs as $item)
                            @if(\App\CusstomPHP\CurrentUser::user()->daily!=$item->ma_cn)
                                <option value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                            @endif
                        @endforeach
                    </select>
                    <table class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Nhận</th>
                            <th>Giá</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="hangnhan"></tbody>
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

    <script>
        var sanphams = [];
        var sp_dachon = {};
        var dataSource = [];
        var dataColumn = [
            {
                data: 'id'
            },
            {
                data: 'ma_sp'
            },
            {
                data: 'ten_sp'
            },
            {
                data: 'SL_sp'
            },
            {
                data: 'giaKM_sp',
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: 'daily_sp'
            }
        ];
        var table = null;
        $(document).ready(function () {
           taiDuLieu();
        });

        function taiDuLieu(){
            NProgress.start();
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_sanphams !!}',
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'json',
                success: function (result) {
                    sanphams = result;
                    hienthi();
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

        function xoaDachon(id) {
            delete sp_dachon[id];
            hienthiSP_DaCHON();
        }
        //Thay đổi số lựog
        function themSL(id) {
            if (sp_dachon[id]['SL_sp'] > sp_dachon[id]['sl_nhan']) {
                sp_dachon[id]['sl_nhan']++;
                hienthiSP_DaCHON();
            } else {
                $.notify('Không có đủ hàng để thêm!', 'error')
            }
        }
        function botSL(id) {
            if (sp_dachon[id]['sl_nhan'] > 0) {
                sp_dachon[id]['sl_nhan']--;
                hienthiSP_DaCHON();
            } else {
                $.notify('Không thể bớt số lượng được nữa!', 'error')
            }
        }
        //Hiển thị lên form
        function hienthi() {
            dataSource=[];
            var tt = 0;
            for (var i = 0; i < sanphams.length; i++) {
                if (parseInt(sanphams[i]['SL_sp']) > 0) {
                    tt = dataSource.length;
                    dataSource[tt] = [];
                    dataSource[tt]['id'] = sanphams[i]['id'];
                    dataSource[tt]['ma_sp'] = sanphams[i]['ma_sp'];
                    dataSource[tt]['ten_sp'] = sanphams[i]['ten_sp'];
                    dataSource[tt]['SL_sp'] = sanphams[i]['SL_sp'];
                    dataSource[tt]['giaKM_sp'] = sanphams[i]['giaKM_sp'];
                    dataSource[tt]['daily_sp'] = sanphams[i]['daily_sp'];

                }
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            table = khoitaobangDATA('bangchuyenhang', dataSource, dataColumn);
            reloadTien();
        }
        function hienthiSP_DaCHON() {
            var html = '';
            var sl_tong = 0;
            var tien_tong = 0;
            for (var i in sp_dachon) {
                html += "<tr title='" + sp_dachon[i]['id'] + "'>";
                html += "<td>" + sp_dachon[i]['id'] + "</td>";
                html += "<td>" + sp_dachon[i]['ma_sp'] + "</td>";
                html += "<td>" + sp_dachon[i]['ten_sp'] + "</td>";
                html += "<td>" +
                        "<div class='btn-group'>" +
                        "<button onclick='themSL(" + i + ");' class='btn btn-default btn-xs'><i class='fa fa-chevron-up'></i></button>" +
                        "<button class='btn btn-default btn-xs'>" + sp_dachon[i]['sl_nhan'] + "</button>" +
                        "<button onclick='botSL(" + i + ");' class='btn btn-default btn-xs'><i class='fa fa-chevron-down'></i></button>" +
                        "</div>" +
                        "</td>";
                html += "<td class='tien'>" + sp_dachon[i]['gia_sp'] + "</td>";
                html += "<td><button onclick='xoaDachon(" + sp_dachon[i]['id'] + ");' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></td>";
                html += "</tr>";
                sl_tong += parseInt(sp_dachon[i]['sl_nhan']);
                tien_tong += parseInt(sp_dachon[i]['gia_sp']) * parseInt(sp_dachon[i]['sl_nhan']);
            }
            html += "<tr><td colspan='3'>Tổng:</td><td>" + sl_tong + "</td><td class='tien'>" + tien_tong + "</td><td></td></tr>";
            $('#hangnhan').html(html);
            reloadTien();
        }
        $('#hanggui').on('click', 'tr', function () {
            var id = $(this).find('td:first-child').text().trim();
            for (var i = 0; i < sanphams.length; i++) {
                if (sanphams[i]['id'] == id) {
                    var kt_co = false;
                    for (var j in sp_dachon) {
                        if (j == id) {
                            if (sanphams[i]['SL_sp'] > parseInt(sp_dachon[j]['sl_nhan'])) {
                                sp_dachon[j]['sl_nhan'] = parseInt(sp_dachon[j]['sl_nhan']) + 1;
                            } else {
                                $.notify('Hết hàng để thêm!', 'error');
                            }
                            kt_co = true;
                        }
                    }
                    if (!kt_co) {
                        if (sanphams[i]['SL_sp'] != 0) {
                            sp_dachon[sanphams[i]['id']] = sanphams[i];
                            sp_dachon[sanphams[i]['id']]['sl_nhan'] = 1;
                        } else {
                            $.notify('Sản phẩm rỗng! Không thể thêm.', 'error');
                        }
                    }
                    break;
                }
            }
            hienthiSP_DaCHON();

        });
        //Chuyển hàng lên server xử lí
        $('#chuyen').click(function () {
            if(navigator.onLine){
                if ($('#daily_nhan').val().trim() == '') {
                    alert('Chưa chọn đại lí nhận!');
                    $('#daily_nhan').focus();
                    return false;
                }
                if(!confirm("Bạn có chắc muốn chuyển số lượng hàng này?")){
                    return false;
                }
                $('#chuyen').html("<i class='fa fa-refresh fa-spin'></i> Đang chuyển...");
                NProgress.start();
                $.post('{!! \App\CusstomPHP\CustomURL::route('chuyen-chuyenhang') !!}', {
                    _token: '{!! csrf_token() !!}',
                    data: JSON.stringify(sp_dachon),
                    daily_nhan: $('#daily_nhan').val()
                }, function (result) {
                    if (result['success']) {
                        $.notify('Chuyển hàng thành công!', 'success');
                        khoiphuc();
                        NProgress.done();
                    } else {
                        $.notify('Chuyển hàng lỗi!', 'error');
                        NProgress.done();
                    }
                    $('#chuyen').html("<i class='fa fa-cloud-upload'></i> Chuyển hàng");
                }).error(function () {
                    $.notify('Lỗi kết nối tới server!', 'error');
                    NProgress.done();
                    $('#chuyen').html("<i class='fa fa-cloud-upload'></i> Chuyển hàng");
                })
            }else{
                alert("Không có kết nối internet. Không thể chuyển hàng!");
            }
        });
        //Khôi phục toàn bộ
        function khoiphuc() {
            for (var j in sp_dachon) {
                delete sp_dachon[j];
            }
            taiDuLieu();
            hienthiSP_DaCHON();
        }
        //Lọc sản phẩm
        $('#search_daily').change(function () {
            table.column(5).search($(this).val()).draw();
        });

    </script>
@stop