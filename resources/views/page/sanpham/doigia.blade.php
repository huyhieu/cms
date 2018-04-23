@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Đổi giá hàng hóa
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
                        <select id="chedogiam" class="form-control input-sm">
                            <option value="">---Chọn chế độ đổi giá---</option>
                            <option value="DONGGIA">Chế độ đồng giá</option>
                            <option value="GIAM%">Chế độ giảm phần trăm</option>
                            <option value="GIAM$">Chế độ giảm lượng giá</option>
                            <option value="KHOIPHUC">Khôi phục giá gốc</option>
                        </select>
                    </li>
                    <li class="dropdown">
                        <input id="giatrigiam" class="form-control input-sm" placeholder="Nhập giá trị...">
                    </li>
                    <li class="dropdown">
                        <a id="xemtruoc"  href="#" class="btn btn-default btn-sm">
                            <i class="fa fa-refresh"></i>
                            Nạp giá
                        </a>
                    </li>
                    <li class="dropdown">
                        <a id="chuyen"  href="#" class="btn btn-primary btn-sm">
                            <i class="fa fa-cloud-upload"></i>
                            Đưa giá lên máy chủ
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-6 haibang">
                    <label>Danh sách hàng:</label>
                    <input placeholder="Nhập một từ khóa tìm kiếm..." id="timhang" class="form-control input-sm input-uppercase" type="text">
                    <table id="bangchuyenhang" class="table bang table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>SL</th>
                            <th>Giá</th>
                            <th>Giá KM</th>
                            <th>Đại lý</th>
                            <th><button id="chonALL" class="btn btn-primary btn-xs">All</button></th>
                        </tr>
                        </thead>
                        <tbody id="hanggui"></tbody>
                    </table>
                </div>
                <div class="col-sm-6 haibang">
                    <label>Xem trước kết quả:</label>
                    <input class="form-control input-sm">
                    <table class="table table-striped table-bordered jambo_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Giá cũ</th>
                            <th>Giá mới</th>
                            <th><button id="xoaALL" class="btn btn-danger btn-xs">All</button></th>
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
        var table = null;
        $(document).ready(function () {
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
        });

        function xoaDachon(id) {
            delete sp_dachon[id];
            hienthiSP_DaCHON();
        }
        //Hiển thị lên form
        function hienthi() {
            var html = '';
            for (var i = 0; i < sanphams.length; i++) {
                if (parseInt(sanphams[i]['SL_sp']) > 0) {
                    html += "<tr  class='chonsp' title='" + sanphams[i]['id'] + "'>";
                    html += "<td>" + sanphams[i]['id'] + "</td>";
                    html += "<td>" + sanphams[i]['ma_sp'] + "</td>";
                    html += "<td>" + sanphams[i]['SL_sp'] + "</td>";
                    html += "<td>" + dinhdangNUMBER(sanphams[i]['gia_sp']) + "</td>";
                    html += "<td>" + dinhdangNUMBER(sanphams[i]['giaKM_sp']) + "</td>";
                    html += "<td>" + sanphams[i]['daily_sp'] + "</td>";
                    html += "<td><button class='btn btn-primary btn-xs'>Chọn</button></td>";
                    html += "</tr>";
                }
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            $('#hanggui').html(html);
            //table=khoitaobang('bangchuyenhang');
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
                html += "<td class='tien'>" + sp_dachon[i]['giaKM_sp'] + "</td>";
                html += "<td class='tien'>" + sp_dachon[i]['giaNEW_sp'] + "</td>";
                html += "<td>" +
                        "<button onclick='xoaDachon(" + sp_dachon[i]['id'] + ");' class='btn btn-xs btn-danger'>" +
                        "<i class='fa fa-trash'></i></button>" +
                        "</td>";
                html += "</tr>";
            }
            $('#hangnhan').html(html);
            reloadTien();
        }

        $('#hanggui').on('click', 'tr', function () {
            var id = $(this).attr('title');
            for (var i = 0; i < sanphams.length; i++) {
                if (sanphams[i]['id'] == id) {
                    if (sp_dachon[id]==undefined) {
                        sp_dachon[id] = sanphams[i];
                        sp_dachon[id]['giaNEW_sp']=sanphams[i]['giaKM_sp']
                    }else{
                        $.notify('Đã thêm sản phẩm này rồi!','warn');
                    }
                    break;
                }
            }
            hienthiSP_DaCHON();
        });
        //Chuyển hàng lên server xử lí
        $('#chuyen').click(function () {

            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('set-doigia') !!}', {
                _token: '{!! csrf_token() !!}',
                sanphams: JSON.stringify(sp_dachon)
            }, function (result) {
                if (result['success']) {
                    $.notify('Đổi giá sản phẩm thành công!', 'success');
                    khoiphuc();
                    NProgress.done();
                } else {
                    $.notify('Đổi giá sản phẩm lỗi!', 'error');
                    NProgress.done();
                }
            }).error(function () {
                $.notify('Lỗi kết nối tới server!', 'error');
                NProgress.done();
            })
        });
        //Khôi phục toàn bộ
        function khoiphuc() {
            for (var j in sp_dachon) {
                delete sp_dachon[j];
            }
            NProgress.start();
            $.post('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                table: '{!! \App\CusstomPHP\Tables::$tb_sanphams !!}',
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                sanphams = result;
                NProgress.done();
                hienthi();
            }).error(function () {
                NProgress.done();
            });
            hienthiSP_DaCHON();
        }
        //Lọc sản phẩm
        $('#search_daily').change(function () {
            //table.column(5).search($(this).val()).draw();
        });

        //Tìm hàng
        $('#timhang').keyup(function () {
            var html = '';
            var chuoi = $('#timhang').val().trim().toUpperCase();
            for (var i = 0; i < sanphams.length; i++) {
                if (parseInt(sanphams[i]['SL_sp']) > 0) {
                    if (sanphams[i]['ma_sp'].indexOf(chuoi) == 0) {
                        html += "<tr title='" + sanphams[i]['id'] + "'>";
                        html += "<td>" + sanphams[i]['id'] + "</td>";
                        html += "<td>" + sanphams[i]['ma_sp'] + "</td>";
                        html += "<td>" + sanphams[i]['SL_sp'] + "</td>";
                        html += "<td class='tien'>" + sanphams[i]['gia_sp'] + "</td>";
                        html += "<td class='tien'>" + sanphams[i]['giaKM_sp'] + "</td>";
                        html += "<td>" + sanphams[i]['daily_sp'] + "</td>";
                        html += "<td><button class='btn btn-primary btn-xs'>Chọn</button></td>";
                        html += "</tr>";
                    }
                }
            }
            $('#hanggui').html(html);
            reloadTien();
        });
        //Chọn tất cả
        $('#chonALL').click(function () {
            var chuoi = $('#timhang').val().trim().toUpperCase();
            for (var i = 0; i < sanphams.length; i++) {
                if (parseInt(sanphams[i]['SL_sp']) > 0) {
                    if (sanphams[i]['ma_sp'].indexOf(chuoi) == 0) {
                        if (sp_dachon[sanphams[i]['id']]==undefined) {
                            sp_dachon[sanphams[i]['id']] = sanphams[i];
                            sp_dachon[sanphams[i]['id']]['giaNEW_sp']=sanphams[i]['giaKM_sp']
                        }else{
                            $.notify('Đã thêm sản phẩm này rồi!','warn');
                        }
                    }
                }
            }
            hienthiSP_DaCHON();
        });
        //Xem trước giá
        $('#xemtruoc').click(function () {
            var chedo=$('#chedogiam').val();
            var giatri=$('#giatrigiam').val();
            if(chedo=='DONGGIA'){
                for(var i in sp_dachon){
                    sp_dachon[i]['giaNEW_sp']=giatri;
                }
            }
            if(chedo=='GIAM%'){
                for(var i in sp_dachon){
                    sp_dachon[i]['giaNEW_sp']=sp_dachon[i]['giaKM_sp']-parseInt(parseInt(sp_dachon[i]['giaKM_sp'])/100*parseInt(giatri));
                }
            }
            if(chedo=='GIAM$'){
                for(var i in sp_dachon){
                    sp_dachon[i]['giaNEW_sp']=sp_dachon[i]['giaKM_sp']-parseInt(giatri);
                }
            }
            if(chedo=='KHOIPHUC'){
                for(var i in sp_dachon){
                    sp_dachon[i]['giaNEW_sp']=sp_dachon[i]['gia_sp'];
                }
            }
            hienthiSP_DaCHON();
        });
        $('#xoaALL').click(function () {
            for (var j in sp_dachon) {
                delete sp_dachon[j];
            }
            hienthiSP_DaCHON();
        })
    </script>
@stop