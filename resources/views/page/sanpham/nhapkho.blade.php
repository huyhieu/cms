@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Nhập hàng vào kho
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button id="luulenSV" class="btn btn-primary btn-sm">
                            <i class="fa fa-cloud-upload"></i> Lưu lên máy chủ
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-6 haibang">
                    <label>Sản phẩm đang có:</label>

                    <div class="bang-themhang">
                        <table id="bangsanphamnhapkho" class="table bang table-striped table-bordered jambo_table">
                            <thead>
                            <tr>
                                <th>TT</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>SL</th>
                                <th>Đơn vị</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6 haibang">
                    <label>Sản phẩm sẽ thêm:</label>

                    <div class="bang-themhang">
                        <table id="bangsanphamthem" class="table bang table-striped table-bordered jambo_table">
                            <thead>
                            <tr>
                                <th>TT</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>SL thêm</th>
                                <th>Giá</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="sanpham"></tbody>
                        </table>
                    </div>
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
        var dataSource = [];
        var dataColumn = [
            {data: 'tt'},
            {data: 'ma_sp'},
            {data: 'ten_sp'},
            {data: 'SL_sp'},
            {data: 'donvi_sp'}
        ];
        var sp_dathem = [];
        var themhang = $('#themhangTolist');
        var luuSP = $('#luulenSV');
        var table = null;

        function taiDulieu(){
            NProgress.start();
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('getsanphamKHO-ajax') !!}',
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

        $(document).ready(function () {
            taiDulieu();
        });

        //Hiển thị lên form
        function hienthi() {
            dataSource = [];
            var tt = 0;
            for (var i = 0; i < sanphams.length; i++) {
                dataSource[tt] = [];
                dataSource[tt]['tt'] = tt;
                dataSource[tt]['ma_sp'] = sanphams[i]['ma_sp'];
                dataSource[tt]['ten_sp'] = sanphams[i]['ten_sp'];
                dataSource[tt]['SL_sp'] = sanphams[i]['SL_sp'];
                dataSource[tt]['donvi_sp'] = sanphams[i]['donvi_sp'];
                tt++;
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            table = $('#bangsanphamnhapkho').DataTable({
                data: dataSource,
                fixedHeader: true,
                columns: dataColumn,
                pageLength: 10,
                order: [[0, "desc"]]
            });
        }
        //Tự động điền thông tin sản phẩm khi thêm
        $('#bangsanphamnhapkho').find('tbody').on('click', 'tr', function () {
            $(this).addClass('selected');
            var maSP = table.row('.selected').data()['ma_sp'];
            table.row('.selected').remove().draw();
            var sp = null;
            for (var i = 0; i < sanphams.length; i++) {
                if (sanphams[i]['ma_sp'] == maSP) {
                    sp = sanphams[i];
                }
            }
            if (sp != null) {
                sp['_token'] = '{!! csrf_token() !!}';
                sp['SL_sp'] = 0;
                if (check_dathem(sp) >= 0) {
                    sp_dathem[check_dathem(sp)] = sp;
                } else {
                    sp_dathem[sp_dathem.length] = sp;
                }
            }
            hienthilenTable();
            $('#bangsanphamnhapkho').find('tbody>tr').removeClass('selected');
        });

        $('#SL_sp').keypress(function (e) {
            if (e.which == 13) {
                if ($('#gia_sp').val() == '') {
                    $('#gia_sp').focus();
                }
                else {
                    themhang.click();
                }
            }
            //
        });


        //Hiển thị lên table
        var SuaSL = null;
        function hienthilenTable() {
            var html = '';
            for (var i = 0; i < sp_dathem.length; i++) {
                html += "<tr>";
                html += "<td>" + i + "</td>";
                html += "<td>" + sp_dathem[i]['ma_sp'] + "</td>";
                html += "<td>" + sp_dathem[i]['ten_sp'] + "</td>";
                html += "<td><input class='form-control input-sm input-table input-SL_sp' id='input" + i + "' title='" + i + "' value='" + sp_dathem[i]['SL_sp'] + "'></td>";
                html += "<td>" + dinhdangNUMBER(sp_dathem[i]['giaKM_sp']) + "</td>";
                html += "<td>" +
                        "<button onclick='xoaSP(" + i + ");' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Xóa</button>" +
                        "</td>";
                html += "</tr>";
            }
            $('#sanpham').html(html);
            //Sửa số lượng
            SuaSL = null;
            $(".input-SL_sp").on("click", function () {
                $(this).select();
            });
            //Dy chuyển
            $('.input-SL_sp').keyup(function (e) {
                if (e.which == 38) {
                    //UP
                    var tt = $(this).attr('title');
                    setTimeout(function () {
                        $('#input' + (parseInt(tt) - 1)).focus();
                        $('#input' + (parseInt(tt) - 1)).select();
                    }, 1);
                }
                if (e.which == 40) {
                    //Down
                    var tt = $(this).attr('title');
                    setTimeout(function () {
                        $('#input' + (parseInt(tt) + 1)).focus();
                        $('#input' + (parseInt(tt) + 1)).select();
                    }, 1);
                }
            });
            SuaSL = $('.input-SL_sp').focusout(function () {
                if ($(this).val().trim() != '') {
                    var tt = $(this).attr('title');
                    sp_dathem[tt]['SL_sp'] = parseInt($(this).val());
                    hienthilenTable();
                } else {
                    alert('Số lượng lỗi!');
                    setTimeout(function () {
                        $('#input' + (parseInt(tt))).focus();
                        $('#input' + (parseInt(tt))).select();
                    }, 1);
                    return false;
                }
            });

        }
        //Kiểm tra hàng tồn tại
        function check_dathem(sanpham) {
            for (var i = 0; i < sp_dathem.length; i++) {
                if (sp_dathem[i]['ma_sp'] == sanpham['ma_sp']) {
                    return i;
                }
            }
            return -1;
        }
        //Lưu lên server
        luuSP.click(function () {
            if (navigator.onLine) {
                hienthilenTable();
                if (confirm("Bạn có chắc muốn thêm số sản phẩm này vào kho?")) {
                    var dathem = 0;
                    for (var i = 0; i < sp_dathem.length; i++) {
                        $.post("{!! \App\CusstomPHP\CustomURL::route('them-sanpham') !!}", sp_dathem[i],
                                function (result) {
                                    dathem++;
                                    luuSP.html("<i></i> Đang thêm...(" + dathem + "/" + sp_dathem.length + ")");
                                    if (dathem >= sp_dathem.length) {
                                        luuSP.html("<i class='fa fa-cloud-upload'></i> Lưu lên máy chủ");
                                        $.notify('Thêm sản phẩm thành công!', 'success');
                                        sp_dathem=[];
                                        hienthilenTable();
                                        taiDulieu();
                                        table.rows().remove().draw()
                                    }
                                }).error(function () {
                                    $.notify("Lỗi kết nối!", 'error');
                                });
                    }
                }
                hienthilenTable();
            } else {
                $.notify('Không có kết nối mạng!', 'warn');
            }
        });


        //Sửa sản phẩm
        function suaSP(id) {
            $('#ma_sp').val(sp_dathem[id]['ma_sp']);
            $('#ten_sp').val(sp_dathem[id]['ten_sp']);
            $('#donvi_sp').val(sp_dathem[id]['donvi_sp']);
            $('#SL_sp').val(sp_dathem[id]['SL_sp']);
            $('#giaNHAP_sp').autoNumeric('set', sp_dathem[id]['giaNHAP_sp']);
            $('#gia_sp').autoNumeric('set', sp_dathem[id]['gia_sp']);
            $('#giaKM_sp').autoNumeric('set', sp_dathem[id]['giaKM_sp']);
            $('#ghichu_sp').val(sp_dathem[id]['ghichu_sp']);
            $('#phanloai').attr('disabled', true);
            $('#ma_sp').focus();
        }
        function xoaSP(id) {
            if (confirm("Bạn có chắc muốn xóa?")) {
                sp_dathem.splice(id, 1);
            }
            hienthilenTable();
        }
        $('#ma_sp').keyup(function () {
            $('#ten_sp').val($(this).val());
        });
        //Tự động điền khuyến mãi
        $('#gia_sp').keypress(function () {
            var gia = $(this).autoNumeric('get');
            $('#giaNHAP_sp').autoNumeric('set', gia);
            $('#giaKM_sp').autoNumeric('set', gia);
        });
    </script>
@stop