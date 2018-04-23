@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
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
                        <select id="search_daily" class="form-control input-sm">
                            <option value="">Tất cả đại lý</option>
                            <option value="KHO">Kho hàng</option>
                            <option value="DL1">Trần Hưng Đạo</option>
                        </select>
                    </li>
                    <li class="dropdown">
                        <a id="themsanpham" data-toggle="modal" data-target=".modal-sanpham" href="#"
                           class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                            Thêm hàng
                        </a>
                    </li>
                    <li class="dropdown">
                        <a id="suasanpham" href="#" class="btn disabled btn-info btn-sm">
                            <i class="fa fa-pencil"></i>
                            Sửa hàng
                        </a>
                    </li>
                    <li class="dropdown">
                        <a id="xoasanpham" href="#" class="btn disabled btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                            Xóa hàng
                        </a>
                    </li>
                    <li class="dropdown">
                        <a onclick="table.ajax.reload();" href="#" class="btn btn-default btn-sm">
                            <i class="fa fa-refresh"></i>
                            Reload
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>

                <table id="banhang" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại</th>
                        <th>SL</th>
                        <th>Đơn vị</th>
                        <th>Giá</th>
                        <th>Giá KM</th>
                        <th>Đại lý</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade modal-sanpham" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Thêm sản phẩm mới</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mã hàng:</label>
                            <input id="ma_sp" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Tên hàng:</label>
                            <input id="ten_sp" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Giá hàng:</label>
                            <input id="gia_sp" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Số lượng hàng:</label>
                            <input id="SL_sp" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Giá KM:</label>
                            <input id="giaKM_sp" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Đơn vị tính:</label>
                            <select id="donvi_sp" class="form-control input-sm">
                                <option value="CHIẾC">CHIẾC</option>
                                <option value="BỘ">BỘ</option>
                            </select>
                        </div>
                        <div class="col-sm-6 hidden hide">
                            <label>Đại lí:</label>
                            <input id="daily_sp" value="KHO" readonly type="text" class="form-control input-sm">
                        </div>
                        <div class="col-sm-12">
                            <label>Phân loại:</label>
                            <input id="phanloai" value="S, M, L, XL, XXL" class="form-control input-sm" type="text">
                            <input class="nhap" type="hidden" value="" id="loai_sp">
                        </div>
                    </div>
                    <label>Ghi chú:</label>
                    <textarea id="ghichu_sp" class="form-control nhap input-sm"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button id="btnsanpham" type="button" class="btn btn-primary">Thêm sản phẩm</button>
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
                <?php $columms = array("id","ma_sp","ten_sp","loai_sp","SL_sp","donvi_sp","gia_sp","giaKM_sp","daily_sp","ngaytao","ngaysua","ghichu_sp"); ?>
                var dataColumn = [
                @foreach($columms as $item)
                    {
                data: "{!! $item !!}"
            },
            @endforeach
    ];
        var table = khoitaobangAjax('banhang', "{!! \App\CusstomPHP\CustomURL::route('get-sanpham') !!}", dataColumn);

        var CHEDO = 'them';
        var btnSanpham = $('#btnsanpham');
        var modalSP = $('.modal-sanpham');
        var id_sua = "";
        //Thêm sản phẩm
        $('#themsanpham').click(function () {
            CHEDO = 'them';
            btnSanpham.text("Thêm sản phẩm");
            $('.nhap').val("");
        });
        //Xóa sản phẩm
        $('#xoasanpham').click(function () {
            if(confirm('Bạn có chắc muốn xóa sản phẩm này?')){
                var id = $('#banhang').find('.selected>td:first-child').text().trim();
                $.post("{!! \App\CusstomPHP\CustomURL::route('xoa-sanpham') !!}", {
                    _token: "{!! csrf_token() !!}",
                    id: id
                }, function (result) {
                    $.notify("Xóa sản phẩm thành công!", 'success');
                    table.ajax.reload();
                })
            }else{

            }
        });
        //Sửa sản phẩm
        $('#suasanpham').click(function () {
            CHEDO = 'sua';
            $('#suasanpham').html("<i class='fa fa-refresh fa-spin'></i> Đang nạp...");
            btnSanpham.text("Sửa sản phẩm");

            //Nạp dữ liệu
            var id = $('#banhang').find('.selected>td:first-child').text().trim();
            id_sua = id;
            $.get("{!! \App\CusstomPHP\CustomURL::route('get-sanpham') !!}", {
                dieukien: 'id',
                giatri: id
            }, function (result) {
                $('#suasanpham').html("<i class='fa fa-pencil'></i> Sửa hàng");
                result = JSON.parse(result);
                modalSP.modal('show');
                <?php echo \App\CusstomPHP\Tables::setDataJquery(\App\CusstomPHP\Tables::$tb_sanphams) ?>
                $('#phanloai').val(result['loai_sp']);
                $('#loai_sp').val(result['loai_sp']);
            });

        });

        btnSanpham.click(function () {
            if (CHEDO == 'them') {
                btnSanpham.html("<i class='fa fa-spin fa-refresh'></i> Đang thêm hàng...");
                //Lấy dữ liệu
                if ($('#phanloai').val() != '') {
                    var loais = $('#phanloai').val().split(',');
                    var soluong = loais.length;
                    var dathem = 0;
                    for (var i = 0; i < loais.length; i++) {
                        $('#loai_sp').val(loais[i].trim());
                        var data = {<?php echo \App\CusstomPHP\Tables::getDataJquery(\App\CusstomPHP\Tables::$tb_sanphams); ?>};
                        $.post("{!! \App\CusstomPHP\CustomURL::route('them-sanpham') !!}", data, function (result) {
                            dathem++;
                            btnSanpham.html("<i class='fa fa-spin fa-refresh'></i> Đang thêm hàng(" + dathem + "/" + soluong + ")...");
                            if (dathem >= soluong) {
                                $.notify("Thêm sản phẩm thành công!", 'success');
                                btnSanpham.html("Thêm sản phẩm");
                                table.ajax.reload();
                            }
                        })
                    }
                }
            }
            if (CHEDO == 'sua') {
                btnSanpham.html("<i class='fa fa-spin fa-refresh'></i> Đang sửa hàng...");
                //Lấy dữ liệu
                var data2 = {<?php echo \App\CusstomPHP\Tables::getDataJquery(\App\CusstomPHP\Tables::$tb_sanphams); ?>};
                data2['id'] = id_sua;
                $.post("{!! \App\CusstomPHP\CustomURL::route('sua-sanpham') !!}", data2, function (result) {
                    $.notify("Sửa sản phẩm thành công!", 'success');
                    btnSanpham.html("Sửa sản phẩm");
                    table.ajax.reload();
                })
            }
        });


        //Chọn sản phẩm
        $('#banhang').find('tbody').on('click', 'tr', function () {
            $('#banhang').find('tr').removeClass('selected');
            $(this).toggleClass('selected');
            $('#suasanpham').removeClass('disabled');
            $('#xoasanpham').removeClass('disabled');
        });
        //Lọc sản phẩm
        $('#search_daily').change(function () {
            table.column(8).search($(this).val()).draw();
        });

    </script>
    {{--///DataTable--}}
    {{--Tags--}}
    {!! \App\CusstomPHP\AssetFile::js('tags/bootstrap-tagsinput.min.js') !!}
    {{--/Tags--}}
@stop