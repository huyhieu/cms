@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-md-9 col-sm-9 col-xs-9">
        <div class="x_panel">
            <div class="x_title">
                <h2>Quản lí nhân viên công ty</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>
                <table id="nhanvien" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Level</th>
                        <th>Đại lý</th>
                        <th>Ngày sửa</th>
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
                <h2>Thông tin nhân viên</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form>
                    <p class="text-muted font-13 m-b-30"></p>
                    <label>Tên đăng nhập:</label>
                    <input autocomplete="off" id="username" class="form-control input-sm">
                    <label>Mật khẩu:</label>
                    <input autocomplete="off" id="password" type="password" class="form-control input-sm">
                    <label>Họ tên nhân viên:</label>
                    <input id="name" class="form-control input-sm">
                    <label>Email:</label>
                    <input id="email" type="email" class="form-control input-sm">
                    <label>Số điện thoại:</label>
                    <input id="sdt" class="form-control input-sm">
                    <label>Cấp độ:</label>
                    <select id="level" class="form-control input-sm">
                        <option value="{!! $NHANVIEN !!}">{!! $txtNHANVIEN !!}</option>
                        <option value="{!! $QUANLY !!}">{!! $txtQUANLY !!}</option>
                    </select>
                    <label>Chi nhánh</label>
                    <select id="daily" class="form-control input-sm">
                        @foreach($chinhanhs as $item)
                            <option value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                        @endforeach
                    </select>
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
                            Lưu
                        </button>
                        <button type="button" id="btn_delete" class="btn disabled khoa btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                            Xóa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop


@section('script')
    <script>
        var nhanviens = JSON.parse('{!! json_encode($nhanviens) !!}');
        var chinhanhs = JSON.parse('{!! json_encode($chinhanhs) !!}');
        var btn_save = $('#btn_save');
        var btn_add = $('#btn_add');
        var btn_delete = $('#btn_delete');
        var bangCN = $('#nhanvien').find('tbody');
        var id_chon = '';

        //Load data lên table
        $(document).ready(function () {
            hienthi();
        });

        btn_add.click(function () {
            if($('#username').val().trim()==''){
                alert("Không thể bỏ trống tên đăng nhập!");
                return;
            }
            $.post("{!! \App\CusstomPHP\CustomURL::route('them-nhanvien') !!}", {
                username: $('#username').val(),
                name:$('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                level: $('#level').val(),
                sdt: $('#sdt').val(),
                daily: $('#daily').val(),
                trangthai: $('#trangthai').val(),
                ghichu: $('#ghichu').val(),
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Thêm thành công nhân viên!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Thêm nhân viên lỗi!", 'error');
                }
            });
        });
        btn_save.click(function () {
            $.post("{!! \App\CusstomPHP\CustomURL::route('sua-nhanvien') !!}", {
                id: id_chon,
                username: $('#username').val(),
                name:$('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                level: $('#level').val(),
                sdt: $('#sdt').val(),
                daily: $('#daily').val(),
                trangthai: $('#trangthai').val(),
                ghichu: $('#ghichu').val(),
                _token:'{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Sửa thành công nhân viên!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Sửa nhân viên lỗi!", 'error');
                }
            })
        });
        btn_delete.click(function () {
            $.post("{!! \App\CusstomPHP\CustomURL::route('xoa-nhanvien') !!}", {
                id: id_chon,
                _token: '{!! csrf_token() !!}'
            }, function (result) {
                if (result['success']) {
                    $.notify("Xóa thành công nhân viên!", 'success');
                    window.location.reload();
                } else {
                    $.notify("Xóa nhân viên lỗi!", 'error');
                }
            })
        });

        bangCN.on('click', 'tr', function () {
            id_chon = $(this).find('td:first').text();
            $('#password').val('');
            $('.khoa').removeClass('disabled');
            for (var i = 0; i < nhanviens.length; i++) {
                if (nhanviens[i]['id'] == id_chon) {
                    $('#username').val(nhanviens[i]['username']);
                    $('#name').val(nhanviens[i]['name']);
                    $('#email').val(nhanviens[i]['email']);
                    $('#level').val(nhanviens[i]['level']);
                    $('#sdt').val(nhanviens[i]['sdt']);
                    $('#daily').val(nhanviens[i]['daily']);
                    $('#trangthai').val(nhanviens[i]['trangthai']);
                    $('#ghichu').val(nhanviens[i]['ghichu']);
                }
            }
        });


        function hienthi() {
            var html = '';
            var trangthai = '';
            var level = '';
            for (var i = 0; i < nhanviens.length; i++) {
                if (nhanviens[i]['trangthai'] == '{!! \App\CusstomPHP\State::$tt_HoatDong !!}') {
                    trangthai = '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_HoatDong) !!}';
                } else {
                    trangthai = '{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_VoHieuHoa) !!}';
                }
                if (nhanviens[i]['level'] == '{!! $NHANVIEN !!}') {
                    level = '{!! $txtNHANVIEN !!}';
                } else {
                    level = '{!! $txtQUANLY !!}';
                }

                html += '<tr>';
                html += "<td>" + nhanviens[i]['id'] + "</td>";
                html += "<td>" + nhanviens[i]['username'] + "</td>";
                html += "<td>" + nhanviens[i]['name'] + "</td>";
                html += "<td>" + nhanviens[i]['email'] + "</td>";
                html += "<td>" + nhanviens[i]['sdt'] + "</td>";
                html += "<td>" + level + "</td>";
                html += "<td>" + getTenChiNhanh(nhanviens[i]['daily']) + "</td>";
                html += "<td>" + nhanviens[i]['updated_at'] + "</td>";
                html += "<td>" + trangthai + "</td>";
                html += '</tr>';
            }
            bangCN.html(html);
        }

        function getTenChiNhanh(ma_cn) {
            for (var i = 0; i < chinhanhs.length; i++) {
                if (chinhanhs[i]['ma_cn'] == ma_cn) {
                    return chinhanhs[i]['ten_cn'];
                }
            }
        }
    </script>
@stop