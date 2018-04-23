@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12" id="view_trang">
        <div class="x_panel" style="padding: 10px 2px;">
            <div class="x_title" style="margin-bottom: 0;">
                <h2>
                    <input class="input-sm form-control" id="key_search" style="width: 100%;"
                           placeholder="Nhập từ khóa tìm kiếm....">
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
                    <li class="dropdown quanli">
                        <a id="themsanpham" data-toggle="modal" data-target=".modal-sanpham" href="#"
                           class="btn btn-primary btn-sm disabled">
                            <i class="fa fa-plus"></i>
                            Thêm hàng
                        </a>
                    </li>
                    <li class="dropdown quanli">
                        <a id="suasanpham" href="#" class="btn disabled btn-info btn-sm">
                            <i class="fa fa-pencil"></i>
                            Sửa hàng
                        </a>
                    </li>
                    <li class="dropdown quanli">
                        <a id="xoasanpham" href="#" class="btn disabled btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                            Xóa hàng
                        </a>
                    </li>
                    <li class="dropdown">
                        <a id="mavach_view" href="#" class="btn disabled btn-default btn-sm">
                            <i class="fa fa-barcode"></i>
                            Mã vạch
                        </a>
                    </li>
                    <li class="dropdown">
                        <a onclick="taiDulieu();" href="#" class="btn btn-default btn-sm">
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
                        <th>SL</th>
                        <th>Đơn vị</th>
                        {{--<th>Giá nhập</th>--}}
                        <th>Giá</th>
                        <th>Giá KM</th>
                        <th>Đại lý</th>
                        {{--<th>Ngày tạo</th>--}}
                        <th>Ngày sửa</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody id="hienthinoidungsanpham"></tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right">
                            Tổng cộng:
                        </th>
                        <th></th>
                        <th></th>
                        {{--<th></th>--}}
                        <th></th>
                        <th></th>
                        <th></th>
                        {{--<th></th>--}}
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
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
                    <h4 class="modal-title" id="title-modal-sp">Thêm sản phẩm mới</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mã hàng:</label>
                            <input list="list_mahang" id="ma_sp" type="text" class="form-control nhap input-sm">
                            <datalist id="list_mahang"></datalist>
                        </div>
                        <div class="col-sm-6">
                            <label>Tên hàng:</label>
                            <input id="ten_sp" type="text" class="form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Giá hàng:</label>
                            <input id="gia_sp" type="text" class="tien-input form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Số lượng hàng:</label>
                            <input id="SL_sp" type="text" class=" form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Giá nhập:</label>
                            <input id="giaNHAP_sp" type="text" class="tien-input form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Đơn vị tính:</label>
                            <select id="donvi_sp" class="form-control input-sm">
                                <option value="CHIẾC">CHIẾC</option>
                                <option value="BỘ">BỘ</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Giá KM:</label>
                            <input id="giaKM_sp" type="text" class="tien-input form-control nhap input-sm">
                        </div>
                        <div class="col-sm-6">
                            <label>Đại lí:</label>
                            <select id="daily_sp" class="form-control input-sm">
                                @foreach($chinhanhs as $item)
                                    @if($item->ma_cn=='KHO')
                                        <option selected value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                                    @else
                                        <option value="{!! $item->ma_cn !!}">{!! $item->ten_cn !!}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label>Phân loại tự động:</label>
                            <input id="phanloai" value="" placeholder="Hãy nhập cách nhau một dấu phẩy..."
                                   class="form-control input-sm" type="text">
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

    <div class="modal fade modal-mavach" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Xem mã vạch sản phẩm</h4>
                </div>
                <div class="modal-body text-center">
                    <div style="width: auto; height: auto; margin: 0;">
                        <div id="hinhinma" class="hinhinma clearfix" style="margin: 0; text-align: center;">
                            <div class="ma-trai clearfix" style="width: 173px;border-right: 1px solid;">
                                <img class="barcode" src="">

                                <div class="gia_ma">Giá: <span class="gia_ma_gia tien-input"></span></div>
                            </div>
                            <div class="ma-phai clearfix" style="width: 173px;">
                                <img src="" class="barcode">

                                <div class="gia_ma">Giá: <span class="gia_ma_gia tien-input"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                    <button id="taimavach" type="button" class="btn btn-primary"><i class="fa fa-download"></i> Tải mã
                        vạch
                    </button>
                    <button id="inmavach" type="button" class="btn btn-primary">
                        <i class="fa fa-print"></i>
                        In mã
                    </button>
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
    {!! \App\CusstomPHP\AssetFile::js('JsBarcode/JsBarcode128.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('JsBarcode/download.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('Print/jQuery.print.js') !!}
    <script>
        var chinhanhs=[];
        var table = null;
        var dataSource=[];
        var dataColumn = [
            {
                data: "id"
            },
            {
                data: "ma_sp"
            },
            {
                data: "ten_sp"
            },
            {
                data: "SL_sp",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "donvi_sp"
            },
//            {
//                data: "giaNHAP_sp",
//                render: $.fn.dataTable.render.number('.', ',', 0)
//            },
            {
                data: "gia_sp",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "giaKM_sp",
                render: $.fn.dataTable.render.number('.', ',', 0)
            },
            {
                data: "daily_sp"
            },
//            {
//                data: "ngaytao"
//            },
            {
                data: "ngaysua"
            },
            {
                data: "ghichu_sp"
            }
        ];
        function hienthi() {
            var bd= Date.now();
            dataSource=[];
            NProgress.start();
            if (table != null) {
                table.clear();
                table.destroy();
            }
            var tt=0;
            console.log('Xóa bảng mất: '+parseInt(Date.now()-bd)+"ms");
            for(var i=0;i<sanphams.length;i++){
                if(sanphams[i]['daily_sp']==$('#search_daily').val() || $('#search_daily').val()==''){
                    dataSource[tt]=[];
                    dataSource[tt]['id']=sanphams[i]['id'];
                    dataSource[tt]['ma_sp']=sanphams[i]['ma_sp'];
                    dataSource[tt]['ten_sp']=sanphams[i]['ten_sp'];
                    dataSource[tt]['SL_sp']=sanphams[i]['SL_sp'];
                    dataSource[tt]['donvi_sp']=sanphams[i]['donvi_sp'];
//                    dataSource[tt]['giaNHAP_sp']=sanphams[i]['giaNHAP_sp'];
                    dataSource[tt]['gia_sp']=sanphams[i]['gia_sp'];
                    dataSource[tt]['giaKM_sp']=sanphams[i]['giaKM_sp'];
//                    for(var k=0;k<chinhanhs.length;k++){
//                        if(sanphams[i]['daily_sp']==chinhanhs[k]['ma_cn']){
//                            dataSource[tt]['daily_sp']=chinhanhs[k]['ten_cn'];
//                        }
//                    }
                    dataSource[tt]['daily_sp']=sanphams[i]['daily_sp'];
//                    dataSource[tt]['ngaytao']=moment(sanphams[i]['ngaytao'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                    dataSource[tt]['ngaysua']=moment(sanphams[i]['ngaysua'], "HH:mm DD/MM/YYYY").format('DD/MM/YYYY');
                    dataSource[tt]['ghichu_sp']=sanphams[i]['ghichu_sp'];
                    tt++;
                }
            }
            console.log('Tạo source mất: '+parseInt(Date.now()-bd)+"ms");
            table = khoitaobangDATA('banhang', dataSource, dataColumn);
            console.log('Khởi tạo mất: '+parseInt(Date.now()-bd)+"ms");
            //hienThiList_mahang();
            NProgress.done();
            table.on('search.dt', function () {
                tongGT(3, 'table');
                tongGT(5, 'table');
                tongGT(6, 'table');
//                tongGT(7, 'banhang');
            });
            tongGT(3, 'table');
            tongGT(5, 'table');
            tongGT(6, 'table');
//            tongGT(7, 'banhang');
            table.draw();
            console.log('Hiển thị mất: '+parseInt(Date.now()-bd)+"ms");
        }


        var CHEDO = 'them';
        var btnSanpham = $('#btnsanpham');
        var modalSP = $('.modal-sanpham');
        var id_sua = "";

        //Thêm sản phẩm
        $('#themsanpham').click(function () {
            alert('Chức năng bị vô hiệu hóa!');
            return;

            $('#title-modal-sp').text("Thêm sản phảm mới");
            CHEDO = 'them';
            btnSanpham.text("Thêm sản phẩm");
            $('.nhap').val("");
            //Lấy mã ngẫu nhiên
            var str_now = Date.now().toString();
            $('#ma_sp').val("SP" + str_now.substr(str_now.length - 9, 6));
            $('#ten_sp').val($('#ma_sp').val());
            //Điền mẫu
            $('#gia_sp').autoNumeric('set', '0');
            $('#giaNHAP_sp').autoNumeric('set', '0');
            $('#giaKM_sp').autoNumeric('set', '0');
            $('#SL_sp').val('0');
            $('#phanloai').show();
            $('#daily_sp').val('KHO');
            $('#daily_sp').attr('disabled', true);
            $('#ten_sp').focus();
        });
        //Xóa sản phẩm
        $('#xoasanpham').click(function () {
            $('#xoasanpham').html("<i class='fa fa-spin fa-refresh'></i> Đang xóa...");
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                var id = $('#banhang').find('.selected>td:first-child').text().trim();
                $.post("{!! \App\CusstomPHP\CustomURL::route('xoa-sanpham') !!}", {
                    _token: "{!! csrf_token() !!}",
                    id: id
                }, function (result) {
                    if (result['success']) {
                        var start = new Date();
                        $.notify("Xóa sản phẩm thành công!", 'success');
                        xoahang(id);
                        //hienthi();
                        $('#xoasanpham').html("<i class='fa fa-trash'></i> Xóa hàng");
                        var end = new Date();
                        console.log(end - start);
                    } else {
                        $.notify("Xóa sản phẩm lỗi!", 'error');
                        $('#xoasanpham').html("<i class='fa fa-trash'></i> Xóa hàng");
                    }
                }).error(function () {
                    $.notify("Lỗi kết nối!", 'error');
                    $('#xoasanpham').html("<i class='fa fa-trash'></i> Xóa hàng");
                })
            }
        });
        //Sửa sản phẩm
        $('#suasanpham').click(function () {
            $('#title-modal-sp').text("Sửa sản phẩm");
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
                $('#id').val(result['id']);
                $('#ma_sp').val(result['ma_sp']);
                $('#ten_sp').val(result['ten_sp']);
                $('#donvi_sp').val(result['donvi_sp']);
                $('#SL_sp').val(result['SL_sp']);
                $('#giaNHAP_sp').autoNumeric('set', result['giaNHAP_sp']);
                $('#gia_sp').autoNumeric('set', result['gia_sp']);
                $('#giaKM_sp').autoNumeric('set', result['giaKM_sp']);
                $('#anh_sp').val(result['anh_sp']);
                $('#ngaytao').val(result['ngaytao']);
                $('#ngaysua').val(result['ngaysua']);
                $('#daily_sp').val(result['daily_sp']);
                $('#trangthai').val(result['trangthai']);
                $('#ghichu_sp').val(result['ghichu_sp']);
                $('#phanloai').hide();
                $('#daily_sp').attr('disabled', false);
            });
        });

        btnSanpham.click(function () {
            //Kiểm tra nhập
            if ($('#ma_sp').val().trim() == '') {
                alert("Vui lòng nhập đầy đủ thông tin!");
                return;
            }

            if (CHEDO == 'them') {
                //Kiểm tra mã hàng
                if (checkTrungMa($('#ma_sp').val(), $('#daily_sp').val())) {
                    if (!confirm('Sản phẩm này đã tồn tại\nBạn có chắc muốn thêm ' + $('#SL_sp').val() +
                                    ' sản phẩm vào mã này không?')) {
                        return;
                    }
                }
                btnSanpham.html("<i class='fa fa-spin fa-refresh'></i> Đang thêm hàng...");
                //Lấy dữ liệu
                if ($('#phanloai').val().trim() != '') {
                    var loais = $('#phanloai').val().split(',');
                    var soluong = loais.length;
                    var dathem = 0;
                    var data;
                    for (var i = 0; i < loais.length; i++) {
                        data = {
                            id: $('#id').val(),
                            ma_sp: ($('#ma_sp').val() + "." + loais[i].trim()),
                            ten_sp: $('#ten_sp').val(),
                            donvi_sp: $('#donvi_sp').val(),
                            SL_sp: $('#SL_sp').val(),
                            giaNHAP_sp: $('#giaNHAP_sp').autoNumeric('get'),
                            gia_sp: $('#gia_sp').autoNumeric('get'),
                            giaKM_sp: $('#giaKM_sp').autoNumeric('get'),
                            anh_sp: $('#anh_sp').val(),
                            ngaytao: $('#ngaytao').val(),
                            ngaysua: $('#ngaysua').val(),
                            daily_sp: $('#daily_sp').val(),
                            trangthai: $('#trangthai').val(),
                            ghichu_sp: $('#ghichu_sp').val(),
                            _token: '{!! csrf_token() !!}'
                        };
                        $.post("{!! \App\CusstomPHP\CustomURL::route('them-sanpham') !!}", data,
                                function (result) {
                                    themhang(result);
                                    dathem++;
                                    btnSanpham.html("<i class='fa fa-spin fa-refresh'></i> Đang thêm hàng(" + dathem + "/" + soluong + ")...");
                                    if (dathem >= soluong) {
                                        $.notify("Thêm sản phẩm thành công!", 'success');
                                        btnSanpham.html("Thêm sản phẩm");
                                        hienthi();
                                    }
                                }).error(function () {
                                    $.notify("Lỗi kết nối!", 'error');
                                });
                    }
                } else {
                    data = {
                        id: $('#id').val(),
                        ma_sp: $('#ma_sp').val(),
                        ten_sp: $('#ten_sp').val(),
                        donvi_sp: $('#donvi_sp').val(),
                        SL_sp: $('#SL_sp').val(),
                        giaNHAP_sp: $('#giaNHAP_sp').autoNumeric('get'),
                        gia_sp: $('#gia_sp').autoNumeric('get'),
                        giaKM_sp: $('#giaKM_sp').autoNumeric('get'),
                        anh_sp: $('#anh_sp').val(),
                        ngaytao: $('#ngaytao').val(),
                        ngaysua: $('#ngaysua').val(),
                        daily_sp: $('#daily_sp').val(),
                        trangthai: $('#trangthai').val(),
                        ghichu_sp: $('#ghichu_sp').val(),
                        _token: '{!! csrf_token() !!}'
                    };
                    $.post("{!! \App\CusstomPHP\CustomURL::route('them-sanpham') !!}", data, function (result) {
                        themhang(result);
                        $.notify("Thêm sản phẩm thành công!", 'success');
                        btnSanpham.html("Thêm sản phẩm");
                        hienthi();
                    }).error(function () {
                        $.notify("Lỗi kết nối!", 'error');
                        btnSanpham.html("Thêm sản phẩm");
                    });
                }
            }
            if (CHEDO == 'sua') {
                btnSanpham.html("<i class='fa fa-spin fa-refresh'></i> Đang sửa hàng...");
                //Lấy dữ liệu

                var data2 = {
                    id: $('#id').val(),
                    ma_sp: $('#ma_sp').val(),
                    ten_sp: $('#ten_sp').val(),
                    donvi_sp: $('#donvi_sp').val(),
                    SL_sp: $('#SL_sp').val(),
                    giaNHAP_sp: $('#giaNHAP_sp').autoNumeric('get'),
                    gia_sp: $('#gia_sp').autoNumeric('get'),
                    giaKM_sp: $('#giaKM_sp').autoNumeric('get'),
                    anh_sp: $('#anh_sp').val(),
                    ngaytao: $('#ngaytao').val(),
                    ngaysua: $('#ngaysua').val(),
                    daily_sp: $('#daily_sp').val(),
                    trangthai: $('#trangthai').val(),
                    ghichu_sp: $('#ghichu_sp').val(),
                    _token: '{!! csrf_token() !!}'
                };
                data2['id'] = id_sua;
                $.post("{!! \App\CusstomPHP\CustomURL::route('sua-sanpham') !!}", data2, function (result) {
                    suahang(result);
                    $.notify("Sửa sản phẩm thành công!", 'success');
                    btnSanpham.html("Sửa sản phẩm");
                    //hienthi();
                }).error(function () {
                    $.notify("Lỗi kết nối!", 'error');
                    btnSanpham.html("Sửa sản phẩm");
                });
            }
        });


        //Chọn sản phẩm
        $('#banhang').find('tbody').on('click', 'tr', function () {
            //$('#banhang').find('tr').removeClass('selected');
           // $(this).toggleClass('selected');
            $('#suasanpham').removeClass('disabled');
            $('#xoasanpham').removeClass('disabled');
            $('#mavach_view').removeClass('disabled');
        });
        //Lọc sản phẩm
        $('#search_daily').change(function () {
            hienthi();
        });

        //kiểm tra trùng mã hàng
        var sanphams = [];
        $(document).ready(function () {
            taiDulieu();
        });
        //Tải dữ liệu trên mạng về
        function taiDulieu() {
            //$('#view_trang').hide();
            //NProgress.start();
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
                    //$('#view_trang').show();
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
            $.ajax({
                method: 'GET',
                url: '{!! \App\CusstomPHP\CustomURL::route('all-ajax') !!}',
                data: {
                    table: '{!! \App\CusstomPHP\Tables::$tb_chinhanhs !!}',
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'json',
                success: function (result) {
                    chinhanhs = result;
                },
                error: function () {
                    if (confirm("Tải dữ liệu bị lỗi!\nBạn có muốn tải lại?")) {
                        taiDulieu();
                    } else {
                        location.reload()
                    }
                }
            });
        }
        function hienThiList_mahang() {
//            var html = '';
//            for (var i = 0; i < sanphams.length; i++) {
//                if (sanphams[i]['daily_sp'] == 'KHO') {
//                    html += "<option value='" + sanphams[i]['ma_sp'] + "'></option>"
//                }
//            }
//            $('#list_mahang').html(html);
        }
        function checkTrungMa(mahang, daily) {
            for (var i = 0; i < sanphams.length; i++) {
                if (mahang == sanphams[i]['ma_sp'] && sanphams[i]['daily_sp'] == daily) {
                    return true;
                }
            }
            return false;
        }

        ///////////////////////////////////////
        //Mã vạch
        $('#mavach_view').click(function () {
            var bang = $('#banhang');
            var maSP = '';
            var gia = '';
            var id = $('#banhang').find('.selected>td:first-child').text().trim();
            for (var i = 0; i <= sanphams.length; i++) {
                if (sanphams[i]['id'] == id) {
                    maSP = sanphams[i]['ma_sp'];
                    gia = sanphams[i]['gia_sp'];
                    break;
                }
            }
            JsBarcode(".barcode", maSP, {
                lineColor: "#000000",
                width: 1,
                height: 50,
                font: 'monospace',
                margin: 0,
                marginTop: 10,
                textMargin: 0,
                fontSize: 15,
                flat: true
            });
            //Hiển thị giá
            $('.gia_ma_gia').autoNumeric('set', gia);
            $('.modal-mavach').modal('show');
        });
        $('#taimavach').click(function () {
            var bang = $('#banhang');
            var idSP = bang.find('.selected>td:first-child').text().trim();
            var maSP = bang.find('.selected>td:nth-child(2)').text().trim();
            var sizeSP = bang.find('.selected>td:nth-child(4)').text().trim();
            download($('.barcode').attr('src'), "ID_" + idSP + "_Code_" + maSP + "_Size_" + sizeSP + ".png", "image/png")
        });
        $('#inmavach').click(function () {
            $('#hinhinma').print();
        });
        ////////////////////////////////////////////////////////////////////

        //Tự động điền khuyến mãi
        $('#gia_sp').keypress(function () {
            var gia = $(this).autoNumeric('get');
            $('#giaNHAP_sp').autoNumeric('set', gia);
            $('#giaKM_sp').autoNumeric('set', gia);
        });
        //Tự động điền thông tin sản phẩm khi thêm
        $('#ma_sp').keypress(function (e) {
            if (e.which == 13) {
                for (var i = 0; i < sanphams.length; i++) {
                    if (sanphams[i]['ma_sp'] == $('#ma_sp').val()) {
                        $('#ten_sp').val(sanphams[i]['ma_sp']);
//                        $('#daily_sp').val(sanphams[i]['ma_sp']);
                        $('#gia_sp').autoNumeric('set', sanphams[i]['gia_sp']);
                        $('#giaKM_sp').autoNumeric('set', sanphams[i]['giaKM_sp']);
                        $('#giaNHAP_sp').autoNumeric('set', sanphams[i]['giaNHAP_sp']);
                        $('#SL_sp').focus();
                        break;
                    }
                }
            }
        });
        //Thêm hàng mới
        function themhang(sp) {
            var tontai = false;
            var vitri = -1;
            for (var i = 0; i < sanphams.length; i++) {
                if ((sanphams[i]['ma_sp'] == sp['ma_sp']) && (sanphams[i]['daily_sp'] == sp['daily_sp'])) {
                    tontai = true;
                    vitri = i;
                    break;
                }
            }
            //
            if (!tontai) {
                sanphams[sanphams.length] = sp;
            } else {
                sanphams[vitri] = sp;

            }
            $('#search_daily').val('');
        }
        //Thêm hàng mới
        function suahang(sp) {
            var tontai = false;
            var vitri = -1;
            for (var i = 0; i < sanphams.length; i++) {
                if ((sanphams[i]['ma_sp'] == sp['ma_sp']) && (sanphams[i]['daily_sp'] == sp['daily_sp'])) {
                    tontai = true;
                    vitri = i;
                    break;
                }
            }
            //
            if (tontai) {
                sanphams[vitri] = sp;
            }
            table.row($('#banhang').find('.selected')).data(sp).draw();
            //$('#search_daily').val('');
        }
        //Xóa hàng
        function xoahang(id) {
            for (var i = 0; i < sanphams.length; i++) {
                if (sanphams[i]['id'] == id) {
                    sanphams.splice(i, 1);
                    table.row($('#banhang').find('.selected')).remove().draw();
                    break;
                }
            }
        }
        //Tính tổng giá trị bảng được chọn
        function tongGT(cot, tenbang) {
            var tong = 0;
            if (cot > 3) {
                var SLs=table.column(3, {search: 'applied'}).data();
                var GIAs=table.column(cot, {search: 'applied'}).data();
                for(var jj=0;jj<SLs.length;jj++){
                    tong+=SLs[jj]*GIAs[jj];
                }
            } else {
                table.column(cot, {search: 'applied'}).data().each(function (value, index) {
                    try {
                        tong += parseInt(value);
                    } catch (ex) {
                    }
                });
            }
            $('.' + tenbang).find('> tfoot > tr > th:nth-child(' + (parseInt(cot) - 1) + ')').text(dinhdangNUMBER(tong));
        }
        //Tìm kiếm theo kí tự
        $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var key_search = $('#key_search').val();
                    var value='';
                    if(key_search.indexOf('>$')==0){
                        value = data[6]; //Cột giá sản phẩm
                        key_search=key_search.substr(2,key_search.length);
                        return parseInt(value)<parseInt(key_search);
                    }
                    if(key_search.indexOf('<$')==0){
                        value = data[6]; //Cột giá sản phẩm
                        key_search=key_search.substr(2,key_search.length);
                        return parseInt(value)>parseInt(key_search);
                    }
                    if(key_search.indexOf('>=$')==0){
                        value = data[6]; //Cột giá sản phẩm
                        key_search=key_search.substr(3,key_search.length);
                        return parseInt(value)<=parseInt(key_search);
                    }
                    if(key_search.indexOf('<=$')==0){
                        value = data[6]; //Cột giá sản phẩm
                        key_search=key_search.substr(3,key_search.length);
                        return parseInt(value)>=parseInt(key_search);
                    }
                    if(key_search.indexOf('$')==0){
                        value = data[6]; //Cột giá sản phẩm
                        key_search=key_search.substr(1,key_search.length);
                        return value==key_search;
                    }
                    if(key_search.indexOf('$')>0){
                        //VD: V$3400000
                        var ten_s=key_search.substring(0,key_search.indexOf('$'));
                        var gia_s=key_search.substring(key_search.indexOf('$')+1,key_search.length);
                        var ten=data[2];
                        var gia=data[6];
                        return (parseInt(gia)==parseInt(gia_s)) && (ten.indexOf(ten_s) == 0);
                    }

                    value = data[2]; //Cột tên sản phẩm
                    key_search = key_search.toUpperCase();
                    value = value.toUpperCase();
                    return value.indexOf(key_search) == 0;
                }
        );
        $('#key_search').keyup(function () {
            if (table != null) {
                table.draw();
            }
        });
    </script>
@stop