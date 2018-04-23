@extends('page.master')

@section('style')
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Danh sách khách hàng
                    <small>Tất cả</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class= quanli">
                        <button id="loaibotrung" class="btn btn-default btn-sm">
                            <i class="fa fa-recycle"></i>
                            Làm sạch
                        </button>
                    </li>
                    <li class= quanli">
                        <button id="sua" class="btn disabled btn-default btn-sm">
                            <i class="fa fa-pencil"></i>
                            Sửa thông tin
                        </button>
                    </li>
                    <li class="quanli"><a id="xoa" href="#" class="btn disabled btn-default btn-sm"><i
                                    class="fa fa-trash"></i> Xóa</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>
                <table id="bang_khachhang" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>FB</th>
                        <th>Họ tên</th>
                        <th>Chi nhánh</th>
                        <th>Địa chỉ</th>
                        <th>Số ĐT</th>
                        <th>Điểm</th>
                        <th>Lượt</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade modal-khachhang" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Sửa thông tin khách hàng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id">

                        <div class="col-sm-6">
                            <label>Họ tên:</label>
                            <input id="hoten" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Giới tính:</label>
                            <input id="gioitinh" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>SĐT:</label>
                            <input id="sdt" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Địa chỉ:</label>
                            <input id="diachi" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Điểm:</label>
                            <input id="diem" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Lượt:</label>
                            <input id="luot" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Trạng thái:</label>
                            <select id="trangthai" class="form-control nhap input-sm">
                                <option value="{!! \App\CusstomPHP\State::$tt_Kichhoat !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Kichhoat) !!}</option>
                                <option value="{!! \App\CusstomPHP\State::$tt_VoHieuHoa !!}">{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_VoHieuHoa) !!}</option>
                            </select>
                        </div>

                    </div>
                    <label>Ghi chú:</label>
                    <textarea id="ghichu" class="form-control nhap input-sm"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button id="btn_suakhachhang" type="button" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section('script')
    <script>
        var table=null;
        var chinhanhs=[];
        var khachhangs=[];
        var dataSource=[];
        var dataColumn = [
            {
                data: "id"
            },
            {
                data: "id_fb"
            },
            {
                data: "hoten"
            },
            {
                data: "chinhanh"
            },
            {
                data: "diachi"
            },
            {
                data: "sdt"
            },
            {
                data: "diem",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "luot"
            },
            {
                data: "ngaytao"
            },
            {
                data: "trangthai"
            }
        ];

        $('#xoa').click(function () {
            if(confirm('Bạn có chắc muốn xóa khách hàng này?')){
                var id = $('#bang_khachhang').find('.selected>td:first').text();
                $.post("{!! \App\CusstomPHP\CustomURL::route('xoa-khachhang') !!}", {
                    id: id,
                    _token: "{!! csrf_token() !!}"
                }, function (data) {
                    if(data['success']){
                        $.notify("Xóa thông tin khách hàng thành công!", 'success');
                        location.reload();
                    }else{
                        $.notify("Xóa khách hàng lỗi!", 'error');
                        location.reload();
                    }
                })
            }
        });
        $('#sua').click(function () {
            //Kiểm tra quản lí
            if(!level_quanli){
                $('#diem').attr('disabled',true);
                $('#luot').attr('disabled',true);
            }

            var id = $('#bang_khachhang').find('.selected>td:first').text();
            $('#id').val(id);
            $.get("{!! \App\CusstomPHP\CustomURL::route('get-khachhang') !!}", {id: id}, function (data) {
                data = JSON.parse(data);
                $('#hoten').val(data['hoten']);
                $('#gioitinh').val(data['gioitinh']);
                $('#sdt').val(data['sdt']);
                $('#diachi').val(data['diachi']);
                $('#diem').val(data['diem']);
                $('#luot').val(data['luot']);
                $('#trangthai').val(data['trangthai']);
                $('#ghichu').val(data['ghichu']);
                $('.modal-khachhang').modal('show');
            })
        });
        $('#btn_suakhachhang').click(function () {
            $(this).html("<i class='fa fa-spin fa-refresh'></i> Đang lưu...");
            $.post("{!! \App\CusstomPHP\CustomURL::route('sua-khachhang') !!}", {
                id: $('#id').val(),
                hoten: $('#hoten').val(),
                gioitinh: $('#gioitinh').val(),
                sdt: $('#sdt').val(),
                diachi: $('#diachi').val(),
                diem: $('#diem').val(),
                luot: $('#luot').val(),
                trangthai: $('#trangthai').val(),
                ghichu: $('#ghichu').val(),
                _token: "{!! csrf_token() !!}"
            }, function (data) {
                if(data['success']){
                    $.notify("Sửa thông tin khách hàng thành công!", 'success');
                    $('#btn_suakhachhang').html("Lưu thông tin");
                    location.reload();
                }else{
                    $.notify("Sửa khách hàng lỗi!", 'error');
                    location.reload();
                }

            })
        });

        $('#bang_khachhang').find('tbody').on('click', 'tr', function () {
            $('#bang_khachhang').find('tr').removeClass('selected');
            $(this).toggleClass('selected');
            $('#sua').removeClass('disabled');
            $('#xoa').removeClass('disabled');
        });

        $(document).ready(function () {
            taiDulieu();
        });
        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            NProgress.start();
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_khachhangs !!}',
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'json',
                success: function (result) {
                    khachhangs = result;
                    $.get('{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}', {
                        table: '{!! \App\CusstomPHP\Tables::$tb_chinhanhs !!}',
                        _token: '{!! csrf_token() !!}'
                    }, function (result) {
                        chinhanhs=result;
                        hienthi();
                        NProgress.done();
                    });
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
        function hienthi(){
            dataSource=[];
            var tt=0;
            for(var i=0;i<khachhangs.length;i++){
                dataSource[tt]=[];
                dataSource[tt]['id']=khachhangs[i]['id'];
                dataSource[tt]['hoten']=khachhangs[i]['hoten'].toLowerCase();
                dataSource[tt]['sdt']=khachhangs[i]['sdt'];
                if(khachhangs[i]['id_fb'].length>0){
                    dataSource[tt]['id_fb']='Yes';
                }else{
                    dataSource[tt]['id_fb']='No';
                }
                dataSource[tt]['chinhanh']='Không rõ';
                for(var j=0;j<chinhanhs.length;j++){
                    if(chinhanhs[j]['ma_cn']==khachhangs[i]['chinhanh']){
                        dataSource[tt]['chinhanh']=chinhanhs[j]['ten_cn'];
                    }
                }
                if(khachhangs[i]['diachi'].length>15){
                    dataSource[tt]['diachi']=khachhangs[i]['diachi'].substr(0,15)+'...';
                }else{
                    if(khachhangs[i]['diachi'].length>0){
                        dataSource[tt]['diachi']=khachhangs[i]['diachi'];
                    }else{
                        dataSource[tt]['diachi']=dataSource[tt]['chinhanh'];
                    }
                }
                dataSource[tt]['diem']=khachhangs[i]['diem'];
                dataSource[tt]['code']=khachhangs[i]['code'];
                dataSource[tt]['luot']=khachhangs[i]['luot'];
                dataSource[tt]['ngaytao']=moment(khachhangs[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                if(khachhangs[i]['trangthai']=='{!! \App\CusstomPHP\State::$tt_Kichhoat !!}'){
                    dataSource[tt]['trangthai']='{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Kichhoat) !!}';
                }else{
                    dataSource[tt]['trangthai']='{!! \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_VoHieuHoa) !!}';
                }
                tt++;
            }
            table=$("#bang_khachhang").DataTable({
                data: dataSource,
                columns: dataColumn,
                select: true,
                paging: true,
                dom: "Bfrtip",
                "autoWidth": false,
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    }
                ],
                pageLength: 15,
                order: [[0, "desc"]]
            });
        }
        //Loại bỏ danh sách bị trùng lặp
        $('#loaibotrung').click(function () {
            if(confirm('Bạn có chắc muốn làm sạch thông tin khách hàng trùng lặp?')){
                $.post("{!! \App\CusstomPHP\CustomURL::route('loaiboTrung-khachhang') !!}", {
                    _token: "{!! csrf_token() !!}"
                }, function (data) {
                    if(data['success']){
                        $.notify("Làm sạch thông tin khách hàng thành công!", 'success');
                        taiDulieu();
                    }else{
                        $.notify("Làm sạch khách hàng lỗi!", 'error');
                    }
                })
            }
        })
    </script>
@stop