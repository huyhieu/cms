@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-md-9 col-sm-9 col-xs-9">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bảng chi nhánh công ty</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>
                <table id="chinhanh" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã</th>
                        <th>Tên chi nhánh</th>
                        <th>Địa chỉ</th>
                        <th>SL</th>
                        <th>Giá trị</th>
                        <th>Phone</th>
                        <th>Ngày sửa</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="x_panel" style="padding: 10px 5px">
            <div class="x_title">
                <h2>Thông tin chi nhánh</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form>
                    <p class="text-muted font-13 m-b-30"></p>
                    <label>Mã chi nhánh:</label>
                    <input id="ma_cn" class="form-control input-sm">
                    <label>Tên chi nhánh:</label>
                    <input id="ten_cn" class="form-control input-sm">
                    <label>Địa chỉ:</label>
                    <input id="diachi_cn" class="form-control input-sm">
                    <label>Số điện thoại:</label>
                    <input id="sdt_cn" class="form-control input-sm">
                    <label>Trạng thái:</label>
                    <select id="trangthai" class="form-control input-sm">
                        <option value="{!! \App\CusstomPHP\State::$tt_HoatDong !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_HoatDong) !!}</option>
                        <option value="{!! \App\CusstomPHP\State::$tt_VoHieuHoa !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_VoHieuHoa) !!}</option>
                    </select>
                    <label>Chi chú:</label>
                    <textarea id="ghichu" class="form-control input-sm"></textarea>
                    <hr>
                    <div class="clearfix">
                        <button type="button" id="btn_add" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i>
                            Thêm
                        </button>
                        <button type="button" id="btn_save" class="btn disabled khoa btn-primary btn-sm">
                            <i class="fa fa-save"></i>
                            Lưu</button>
                        <button type="button" id="btn_delete" class="btn disabled khoa btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                            Xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop


@section('script')
    <script>
        var chinhanhs = JSON.parse('{!! json_encode($chinhanhs) !!}');
        var btn_save = $('#btn_save');
        var btn_add = $('#btn_add');
        var btn_delete = $('#btn_delete');
        var bangCN = $('#chinhanh').find('tbody');
        var id_chon = '';

        //Load data lên table
        $(document).ready(function () {
            hienthi();
        });

        btn_add.click(function () {
                $.post("{!! \App\CusstomPHP\CustomURL::route('them-chinhanh') !!}", {
                    ma_cn: $('#ma_cn').val(),
                    ten_cn: $('#ten_cn').val(),
                    diachi_cn: $('#diachi_cn').val(),
                    sdt_cn: $('#sdt_cn').val(),
                    trangthai: $('#trangthai').val(),
                    ghichu: $('#ghichu').val(),
                    _token: '{!! csrf_token() !!}'
                }, function (result) {
                    if (result['success']) {
                        $.notify("Thêm thành công chi nhánh!", 'success');
                        window.location.reload();
                    } else {
                        $.notify("Thêm chi nhánh lỗi!", 'error');
                    }
                });
        });
        btn_save.click(function () {
            $.post("{!! \App\CusstomPHP\CustomURL::route('sua-chinhanh') !!}", {
                id: id_chon,
                ma_cn: $('#ma_cn').val(),
                ten_cn: $('#ten_cn').val(),
                diachi_cn: $('#diachi_cn').val(),
                sdt_cn: $('#sdt_cn').val(),
                trangthai: $('#trangthai').val(),
                ghichu: $('#ghichu').val(),
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Sửa thành công chi nhánh!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Sửa chi nhánh lỗi!", 'error');
                }
            })
        });
        btn_delete.click(function () {
            $.post("{!! \App\CusstomPHP\CustomURL::route('xoa-chinhanh') !!}", {
                id: id_chon,
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Xóa thành công chi nhánh!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Xóa chi nhánh lỗi!", 'error');
                }
            })
        });

        bangCN.on('click', 'tr', function () {
            id_chon = $(this).find('td:first').text();
            $('.khoa').removeClass('disabled');
            for (var i = 0; i < chinhanhs.length; i++) {
                if(chinhanhs[i]['id']==id_chon){
                    $('#ma_cn').val(chinhanhs[i]['ma_cn']);
                    $('#ten_cn').val(chinhanhs[i]['ten_cn']);
                    $('#diachi_cn').val(chinhanhs[i]['diachi_cn']);
                    $('#sdt_cn').val(chinhanhs[i]['sdt_cn']);
                    $('#trangthai').val(chinhanhs[i]['trangthai']);
                    $('#ghichu').val(chinhanhs[i]['ghichu']);
                }
            }
        });


        function hienthi() {
            var html = '';
            var trangthai = '';
            for (var i = 0; i < chinhanhs.length; i++) {
                if (chinhanhs[i]['trangthai'] == '{!! \App\CusstomPHP\State::$tt_HoatDong !!}') {
                    trangthai = '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_HoatDong) !!}';
                } else {
                    trangthai = '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_VoHieuHoa) !!}';
                }

                html += '<tr>';
                html += "<td>" + chinhanhs[i]['id'] + "</td>";
                html += "<td>" + chinhanhs[i]['ma_cn'] + "</td>";
                html += "<td>" + chinhanhs[i]['ten_cn'] + "</td>";
                html += "<td>" + chinhanhs[i]['diachi_cn'] + "</td>";
                html += "<td>" + 0 + "</td>";
                html += "<td>" + 0 + "</td>";
                html += "<td>" + chinhanhs[i]['sdt_cn'] + "</td>";
                html += "<td>" + chinhanhs[i]['ngaysua'] + "</td>";
                html += "<td>" + chinhanhs[i]['ghichu'] + "</td>";
                html += "<td>" + trangthai + "</td>";
                html += '</tr>';
            }
            bangCN.html(html);
        }
    </script>
@stop