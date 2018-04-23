@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('bootstrap-tagsinput.css') !!}
    <style>
        .custom-file-upload {
            padding: 0px;
        }
    </style>
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
                        <label class="btn btn-sm fa fa-upload custom-file-upload">
                            <input type="file" name="xlfile" id="xlf" style="display: none;"> Nhập dữ liệu từ file Excel
                        </label>
                    </li>
                    <li>
                        <button onClick="downloadExclEX()" class="btn btn-sm">
                            <i class="fa fa-file-excel-o"></i> Tải file Excel mẫu
                        </button>
                    </li>
                    <li>
                        <button id="luulenSV" class="btn btn-primary btn-sm">
                            <i class="fa fa-cloud-upload"></i> Lưu lên máy chủ
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-9 haibang">
                    <label>Sản phẩm sẽ thêm:</label>

                    <div class="bang-themhang">
                        <table id="bangsanphamthem" class="table bang table-striped table-bordered jambo_table">
                            <thead>
                            <tr>
                                <th>TT</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>SL</th>
                                <th>Giá</th>
                                <th>Giá KM</th>
                                <th>Đơn vị</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="sanpham"></tbody>
                        </table>
                    </div>

                </div>
                <div class="col-sm-3 haibang bg-success" style="padding-left: 3px; padding-right: 3px;">
                    <div class="col-sm-12">
                        <label>Mã hàng:</label>
                        <input autofocus autocomplete="on" list="list_mahang" id="ma_sp" type="text"
                               class="form-control input-uppercase">
                        <datalist id="list_mahang"></datalist>
                    </div>
                    <div class="col-sm-12">
                        <label>Tên hàng:</label>
                        <input id="ten_sp" type="text" class="form-control input-uppercase">
                    </div>
                    <div class="col-sm-6">
                        <label>Giá hàng:</label>
                        <input id="gia_sp" type="text" class="tien-input form-control nhap">
                    </div>
                    <div class="col-sm-6">
                        <label>Số lượng hàng:</label>
                        <input id="SL_sp" type="text" value="0" class=" form-control nhap">
                    </div>
                    <div class="col-sm-6">
                        <label>Giá nhập:</label>
                        <input id="giaNHAP_sp" type="text" class="tien-input form-control nhap">
                    </div>
                    <div class="col-sm-6">
                        <label>Đơn vị tính:</label>
                        <select id="donvi_sp" class="form-control">
                            <option value="CHIẾC">CHIẾC</option>
                            <option value="BỘ">BỘ</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label>Giá KM:</label>
                        <input id="giaKM_sp" type="text" class="tien-input form-control nhap">
                    </div>
                    <div class="col-sm-6">
                        <label>Đại lí:</label>
                        <select id="daily_sp" class="form-control" disabled>
                            @foreach($chinhanhs as $item)
                                @if($item->ma_cn==$dailyhientai)
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
                               class="form-control input-uppercase" type="text">
                    </div>
                    <div class="col-sm-12">
                        <label>Ghi chú:</label>
                        <textarea id="ghichu_sp" class="form-control nhap input-sm"></textarea>
                    </div>

                    <div class="col-sm-12">
                        <hr style="margin: 5px;">
                        <button id="themhangTolist" class="btn btn-info btn-block">
                            <i class="fa fa-plus"></i>
                            Thêm hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <pre>


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
    {!! \App\CusstomPHP\AssetFile::js('datatable/shim.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/xlsx.full.min.js') !!}
    {!! \App\CusstomPHP\AssetFile::js('datatable/datatable.init.js') !!}
    <script>
        var sanphams = [];
        var sp_dathem = [];
        var themhang = $('#themhangTolist');
        var luuSP = $('#luulenSV');
        var table = null;

        $(document).ready(function () {
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
        });

        //Hiển thị lên form
        function hienthi() {
            var html = '';
            for (var i = 0; i < sanphams.length; i++) {
                html += "<option value='" + sanphams[i]['ma_sp'] + "'></option>"
            }
            $('#list_mahang').html(html);
            html = '';
        }
        //Tự động điền thông tin sản phẩm khi thêm
        $('#ma_sp').keypress(function (e) {
            if (e.which == 13) {
                var check=false;
                for (var i = 0; i < sanphams.length; i++) {
                    if (getCODE(sanphams[i]['ma_sp']).toUpperCase() == getCODE($('#ma_sp').val()).toUpperCase()) {
//                        $('#ten_sp').val(sanphams[i]['ma_sp']);
//                        $('#daily_sp').val(sanphams[i]['ma_sp']);
                        $('#gia_sp').autoNumeric('set', sanphams[i]['gia_sp']);
                        $('#giaKM_sp').autoNumeric('set', sanphams[i]['giaKM_sp']);
                        $('#giaNHAP_sp').autoNumeric('set', sanphams[i]['giaNHAP_sp']);
                        //$('#SL_sp').focus();
                        check=true;
                        break;
                    }
                }
                if(!check_tontai($('#ma_sp').val())){
                    $.notify('Mã tồn tại!','warn');
                }else{
                    $('#SL_sp').val(0);
                    $('#gia_sp').focus();
                }
                if(check){
                    //$('#themhangTolist').click();
                }else{
                    $('#gia_sp').autoNumeric('set', 0);
                    $('#giaKM_sp').autoNumeric('set', 0);
                    $('#giaNHAP_sp').autoNumeric('set', 0);
                }

            }
        });

        //Lấy mã sản phẩm bỏ size
        function getCODE(str){
            return str.substring(0,str.lastIndexOf('.'));
        }

        $('#SL_sp').keypress(function (e) {
            if (e.which == 13) {
                if ($('#gia_sp').val() == '') {
                    $('#gia_sp').focus();
                }
                else {
                    themhang.click();
                }
            }
        });


        //Hiển thị lên table
        function hienthilenTable() {
            var html = '';
            for (var i = 0; i < sp_dathem.length; i++) {
                html += "<tr>";
                html += "<td>" + i + "</td>";
                html += "<td>" + sp_dathem[i]['ma_sp'] + "</td>";
                html += "<td>" + sp_dathem[i]['ten_sp'] + "</td>";
                html += "<td><button onclick='suaSL(" + i + ");' class='btn btn-default btn-xs text-bold'>" + sp_dathem[i]['SL_sp'] + " <i class='fa fa-edit'></i></button></td>";
                html += "<td>" + dinhdangNUMBER(sp_dathem[i]['gia_sp']) + "</td>";
                html += "<td>" + dinhdangNUMBER(sp_dathem[i]['giaKM_sp']) + "</td>";
                html += "<td>" + sp_dathem[i]['donvi_sp'] + "</td>";
                html += "<td>" +
                        "<button onclick='suaSP(" + i + ");' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i> Sửa</button>" +
                        "<button onclick='xoaSP(" + i + ");' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Xóa</button>" +
                        "</td>";
                html += "</tr>";
            }
            if (table != null) {
                table.clear();
                table.destroy();
            }
            $('#sanpham').html(html);
            //table = khoitaobang('bangsanphamthem');
        }
        themhang.click(function () {
            if ($('#SL_sp').val() == '') {
                alert("Chưa nhập số lượng!");
                $('#SL_sp').focus();
                return;
            }
            $('#ten_sp').val($('#ten_sp').val().toUpperCase());
            $('#ma_sp').val($('#ma_sp').val().toUpperCase());
            var phanloai = $('#phanloai');
            phanloai.val(phanloai.val().toUpperCase());
            var data;
            if (phanloai.val().trim() != '') {
                var loais = phanloai.val().split(',');
                for (var i = 0; i < loais.length; i++) {
                    data = {
                        id: $('#id').val(),
                        ma_sp: ($('#ma_sp').val() + "." + loais[i].trim()),
                        ten_sp: ($('#ten_sp').val() + "." + loais[i].trim()),
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
                    if(check_tontai(data['ma_sp'])){
                        if (check_dathem(data) >= 0) {
                            sp_dathem[check_dathem(data)] = data;
                        } else {
                            sp_dathem[sp_dathem.length] = data;
                        }
                    }else{
                        $.notify(data['ma_sp']+" đã tồn tại!",'warn');
                    }
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
                if(check_tontai(data['ma_sp'])){
                    if (check_dathem(data) >= 0) {
                        sp_dathem[check_dathem(data)] = data;
                    } else {
                        sp_dathem[sp_dathem.length] = data;
                    }
                }else{
                    $.notify(data['ma_sp']+" đã tồn tại!",'warn');
                }
            }
            hienthilenTable();
            $('input').val('');
            $('#ma_sp').focus();
            $('#phanloai').attr('disabled', false);
        });
        //Kiểm tra hàng tồn tại
        function check_dathem(sanpham) {
            for (var i = 0; i < sp_dathem.length; i++) {
                if (sp_dathem[i]['ma_sp'] == sanpham['ma_sp']) {
                    return i;
                }
            }
            return -1;
        }
        //Check ma hang ton tại
        function check_tontai(ma_sp) {
            for (var i = 0; i < sanphams.length; i++) {
                if (sanphams[i]['ma_sp'].toUpperCase() + sanphams[i]['daily_sp']== ma_sp.toUpperCase() + $('#daily_sp').val()) {
                    return false;
                }
            }
            return true;
        }

        //Lưu lên server
        luuSP.click(function () {
            if (navigator.onLine) {
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
                                        for (var j = 0; j < sp_dathem.length; j++) {
                                            sp_dathem.splice(j, 1);
                                        }
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
        //Sửa số lượng
        function suaSL(id) {
            var sl = prompt('Nhập vào số lượng thêm:', sp_dathem[id]['SL_sp']);
            if (sl == null) {
                return;
            }
            if ($.isNumeric(sl) != true) {
                alert("Bạn vừa nhập không phải là số!");
                return;
            }
            if (sl >= 0) {
                sp_dathem[id]['SL_sp'] = sl;
            }
            hienthilenTable();
        }
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
        $('#gia_sp').keypress(function (e) {
            if (e.which == 13) {
                if($('#SL_sp').val().trim() !=''){
                    $('#phanloai').focus();
                }
            }else{
                var gia = $(this).autoNumeric('get');
                $('#giaNHAP_sp').autoNumeric('set', gia);
                $('#giaKM_sp').autoNumeric('set', gia);
            }
        });
        //
        //Tự động điền khuyến mãi
        $('#phanloai').keypress(function (e) {
            if (e.which == 13) {
                themhang.click();
            }
        });


        function downloadExclEX() {

            var export_data = '';

            export_data += 'Mã hàng, Tên Hàng, Giá hàng, Giá nhập, Giá khuyến mãi, Số lượng, Đơn vị, Chú thích' + '\n';

            export_data += 'A001, Áo 1, 100000, 50000, 100000, 10, Chiếc, Áo tím' + '\n';

            export_data += 'A002, Áo 2, 200000, 50000, 100000, 10, Bộ, Áo hồng' + '\n';

            var uri = 'data:application/xls;charset=utf-8;' + export_data;
            var downloadLink = document.createElement("a");
            downloadLink.href = uri;
            downloadLink.download = "DuLieuSanPham.xls";

            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

    </script>

    <script>
        /*jshint browser:true */
        /* eslint-env browser */
        /* eslint no-use-before-define:0 */
        /*global Uint8Array, Uint16Array, ArrayBuffer */
        /*global XLSX */
        var X = XLSX;
        var spData;
        var process_wb = (function() {

            return function process_wb(wb) {
                /* get data */
                var ws = wb.Sheets[wb.SheetNames[0]];
                var data = XLSX.utils.sheet_to_json(ws, {header:1});
                spData = data;

                for(var i=1; i<spData.length; i++) {
                    var note = "", tensp = "";
                    if(spData[i][7] != undefined)
                        note = spData[i][7];
                    if(spData[i][1] != undefined)
                        tensp = spData[i][1];

                    if(spData[i][0] != undefined && spData[i][2] != undefined &&
                        spData[i][3] != undefined && spData[i][4] != undefined && spData[i][5] != undefined) {
                        var data = {
                            id: $('#id').val(),
                            ma_sp: spData[i][0],
                            ten_sp: tensp,
                            donvi_sp: spData[i][6],
                            SL_sp: spData[i][5],
                            giaNHAP_sp: spData[i][3],
                            gia_sp: spData[i][2],
                            giaKM_sp: spData[i][4],
                            anh_sp: $('#anh_sp').val(),
                            ngaytao: $('#ngaytao').val(),
                            ngaysua: $('#ngaysua').val(),
                            daily_sp: $('#daily_sp').val(),
                            trangthai: $('#trangthai').val(),
                            ghichu_sp: note,
                            _token: '{!! csrf_token() !!}'
                        };
                        if(check_tontai(data['ma_sp'])){
                            if (check_dathem(data) >= 0) {
                                sp_dathem[check_dathem(data)] = data;
                            } else {
                                sp_dathem[sp_dathem.length] = data;
                            }
                        }else{
                            $.notify(data['ma_sp']+" đã tồn tại!",'warn');
                        }
                    } else  {
                        $.notify("Dòng thứ " + i + " không hợp lệ!",'warn');
                    }

                }

                hienthilenTable();
            };
        })();

        var do_file = (function() {
            var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;

            return function do_file(files) {
                rABS = false;
                var f = files[0];
                if(f==null)
                    return;
                var reader = new FileReader();
                reader.onload = function(e) {
                    if(typeof console !== 'undefined') console.log("onload", new Date(), rABS);
                    var data = e.target.result;
                    if(!rABS) data = new Uint8Array(data);
                    process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
                };
                if(rABS) reader.readAsBinaryString(f);
                else reader.readAsArrayBuffer(f);
            };
        })();

        (function() {
            /*var drop = document.getElementById('drop');
            if(!drop.addEventListener) return;*/

            function handleDrop(e) {
                e.stopPropagation();
                e.preventDefault();
                do_file(e.dataTransfer.files);
            }

            function handleDragover(e) {
                e.stopPropagation();
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            }

            /*drop.addEventListener('dragenter', handleDragover, false);
            drop.addEventListener('dragover', handleDragover, false);
            drop.addEventListener('drop', handleDrop, false);*/
        })();

        (function() {
            var xlf = document.getElementById('xlf');
            if(!xlf.addEventListener) return;
            function handleFile(e) { do_file(e.target.files); }
            xlf.addEventListener('change', handleFile, false);
        })();


    </script>
@stop


