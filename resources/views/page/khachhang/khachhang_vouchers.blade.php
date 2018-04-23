@extends('page.master')

@section('style')
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Danh sách voucher
                    <small>Tất cả</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class= quanli">
                        <button id="loaibotrung" class="btn btn-default btn-sm">
                            <i class="fa fa-recycle"></i>
                            Làm sạch mã cũ
                        </button>
                    </li>
                    <li>
                        <a id="them" href="#" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i>
                            Thêm
                        </a>
                    </li>
                    <li><a id="sua" href="#" class="btn disabled btn-default btn-sm"><i
                                    class="fa fa-pencil"></i> Sửa thông tin</a>
                    </li>
                    <li>
                        <a id="xoa" href="#" class="btn disabled btn-default btn-sm">
                            <i class="fa fa-trash"></i> Xóa</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>
                <table id="bang_khachhang" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Giá trị</th>
                        <th>Hạn dùng</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vouchers as $item)
                        <tr>
                            <td>{!! $item->id !!}</td>
                            <td>{!! $item->code !!}</td>
                            <td>{!! $item->value !!}</td>
                            <td>{!! $item->hethan !!}</td>
                            <td>{!! $item->ngaytao !!}</td>
                            <td>{!! $item->ngaysua !!}</td>
                            <td>{!! \App\CusstomPHP\State::getTxtState($item->trangthai) !!}</td>
                            <td>{!! $item->ghichu !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade modal-khachangvoucher" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="modal-lable">Sửa thông tin khách hàng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id">
                        <div class="col-sm-6">
                            <label>Mã:</label>
                            <input id="code" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Giá trị:</label>
                            <input id="value" type="text" class="form-control nhap input-sm">
                        </div>

                        <div class="col-sm-6">
                            <label>Hạn dùng:</label>
                            <input id="hethan" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Trạng thái:</label>
                            <select id="trangthai"  class="form-control nhap input-sm">
                                <option value="{!! \App\CusstomPHP\State::$tt_HoatDong !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_HoatDong) !!}</option>
                                <option value="{!! \App\CusstomPHP\State::$tt_DaNap !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_DaNap) !!}</option>
                                <option value="{!! \App\CusstomPHP\State::$tt_thanhtoan !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_thanhtoan) !!}</option>
                            </select>
                        </div>
                    </div>
                    <label>Ghi chú:</label>
                    <textarea id="ghichu" class="form-control nhap input-sm"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button id="btn_sua" type="button" class="btn btn-primary">Lưu thông tin</button>
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
        var CHE_DO='';
        $('#xoa').click(function () {
            if(confirm('Bạn có chắc muốn xóa voucher khách hàng này?')){
                var id = $('#bang_khachhang').find('.selected>td:first').text();
                $.post("{!! \App\CusstomPHP\CustomURL::route('xoa-khachangvoucher') !!}", {
                    id: id,
                    _token: "{!! csrf_token() !!}"
                }, function (data) {
                    if(data['success']){
                        $.notify("Xóa voucher khách hàng thành công!", 'success');
                        location.reload();
                    }else{
                        $.notify("Xóa voucher khách hàng lỗi!", 'error');
                        location.reload();
                    }
                })
            }
        });
        $('#sua').click(function () {
            var id = $('#bang_khachhang').find('.selected>td:first').text();
            $('#id').val(id);
            CHE_DO='sua';
            $.get("{!! \App\CusstomPHP\CustomURL::route('get-khachangvoucher') !!}", {id: id}, function (data) {
                data = JSON.parse(data);
                $('#code').val(data['code']);
                $('#value').val(data['value']);
                $('#hethan').val(data['hethan']);
                $('#trangthai').val(data['trangthai']);
                $('#ghichu').val(data['ghichu']);
                $('.modal-khachangvoucher').modal('show');
            })
        });

        $('#them').click(function () {
            $(this).html("<i class='fa fa-spin fa-refresh'></i> Đang nạp..");
            $('.modal-khachangvoucher').find('input,textarea').val('');
            $('#modal-lable').text('Thêm voucher khách hàng mới');
            $('.modal-khachangvoucher').modal('show');
            CHE_DO='them';
            $(this).html("<i class='fa fa-spin fa-refresh'></i> Đang nạp..");
        });
        $('#btn_sua').click(function () {
            if(CHE_DO=='sua'){
                $(this).html("<i class='fa fa-spin fa-refresh'></i> Đang lưu...");
                $.post("{!! \App\CusstomPHP\CustomURL::route('sua-khachangvoucher') !!}", {
                    id: $('#id').val(),
                    code: $('#code').val(),
                    value: $('#value').val(),
                    hethan: $('#hethan').val(),
                    trangthai: $('#trangthai').val(),
                    ghichu: $('#ghichu').val(),
                    _token: "{!! csrf_token() !!}"
                }, function (data) {
                    if(data['success']){
                        $.notify("Sửa thông tin voucher khách hàng thành công!", 'success');
                        $('#btn_suakhachhang').html("Lưu thông tin");
                        location.reload();
                    }else{
                        $.notify("Sửa voucher khách hàng lỗi!", 'error');
                        location.reload();
                    }

                })
            }
            if(CHE_DO=='them'){
                $(this).html("<i class='fa fa-spin fa-refresh'></i> Đang lưu...");
                $.post("{!! \App\CusstomPHP\CustomURL::route('them-khachangvoucher') !!}", {
                    id: $('#id').val(),
                    code: $('#code').val(),
                    value: $('#value').val(),
                    hethan: $('#hethan').val(),
                    trangthai: $('#trangthai').val(),
                    ghichu: $('#ghichu').val(),
                    _token: "{!! csrf_token() !!}"
                }, function (data) {
                    if(data['success']){
                        $.notify("Thêm thông tin voucher khách hàng thành công!", 'success');
                        $('#btn_suakhachhang').html("Lưu thông tin");
                        location.reload();
                    }else{
                        $.notify("Thêm voucher khách hàng lỗi!", 'error');
                        location.reload();
                    }

                })
            }
        });

        $('#bang_khachhang').find('tbody').on('click', 'tr', function () {
            $('#bang_khachhang').find('tr').removeClass('selected');
            $(this).toggleClass('selected');
            $('#sua').removeClass('disabled');
            $('#xoa').removeClass('disabled');
        });

        var bang=null;
        $(document).ready(function () {
            bang=khoitaobang('bang_khachhang');
        });


        //Loại bỏ mã cũ
        $('#loaibotrung').click(function () {
            if(confirm('Bạn có chắc muốn làm sạch mã đã cũ?')){
                $.post("{!! \App\CusstomPHP\CustomURL::route('lamsachVCcu-khachangvoucher') !!}", {
                    _token: "{!! csrf_token() !!}"
                }, function (data) {
                    if(data['success']){
                        $.notify("Làm sạch mã cũ thành công!", 'success');
                        location.reload();
                    }else{
                        $.notify("Làm sạch mã cũ lỗi!", 'error');
                    }
                })
            }
        })
    </script>
@stop