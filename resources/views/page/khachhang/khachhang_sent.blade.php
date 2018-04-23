@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('flat/green.css') !!}
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Danh sách khách hàng
                    <small>Tất cả</small>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-9">
                        <table id="bang_khachhang" class="table table-striped table-bordered jambo_table">
                            <thead>
                            <tr>
                                <th>TT</th>
                                <th>Họ tên</th>
                                <th>Số ĐT</th>
                                <th>Chi nhánh</th>
                                <th>Tích lũy</th>
                                <th>Lượt</th>
                                <th>Ngày tạo</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-white">
                            <label>Nội dung tin nhắn:</label>
                            <textarea id="noidungchinh" class="form-control" rows="5"></textarea>

                            <label>Liên kết:</label>
                            <input id="lienket" readonly class="form-control">

                            <div class="radio">
                                <label>
                                    <input checked value="duocchon" type="radio" class="chedoguitin" name="chedoguitin">
                                    Danh sách được chọn
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input value="tatca" type="radio" class="chedoguitin" name="chedoguitin">
                                    Tất cả khách hàng khả dụng
                                </label>
                            </div>
                            <hr>
                            <button id="bnt_gui" class="btn btn-primary btn-block">
                                <i class="fa fa-send"></i>
                                Gửi tin nhắn
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('script')
    {!! \App\CusstomPHP\AssetFile::js('icheck/icheck.min.js') !!}
    <script>
        var table=null;
        var chinhanhs=[];
        var khachhangs=[];
        var dataSource=[];
        var dataColumn = [
            {
                data: "tt"
            },
            {
                data: "hoten"
            },
            {
                data: "sdt"
            },
            {
                data: "chinhanh"
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
            }
        ];

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
                if(khachhangs[i]['id_fb'].length>0){
                    dataSource[tt]=[];
                    dataSource[tt]['tt']=tt;
                    dataSource[tt]['id']=khachhangs[i]['id'];
                    dataSource[tt]['hoten']=khachhangs[i]['hoten'].toLowerCase();
                    dataSource[tt]['sdt']=khachhangs[i]['sdt'];
                    dataSource[tt]['id_fb']=khachhangs[i]['id_fb'];
                    dataSource[tt]['chinhanh']='Không rõ';
                    for(var j=0;j<chinhanhs.length;j++){
                        if(chinhanhs[j]['ma_cn']==khachhangs[i]['chinhanh']){
                            dataSource[tt]['chinhanh']=chinhanhs[j]['ten_cn'];
                        }
                    }
                    dataSource[tt]['diem']=khachhangs[i]['diem']*parseInt('{!! \App\CusstomPHP\Tables::getValue('donvi_diem',\App\CusstomPHP\Tables::$tb_khachhang_cauhinhs) !!}');
                    dataSource[tt]['luot']=khachhangs[i]['luot'];
                    dataSource[tt]['ngaytao']=khachhangs[i]['ngaytao'];
                    tt++;
                }
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

        //Gửi tin nhắn
        var id_fb = '';
        var token = '{!! \App\Http\Controllers\FacebookController::$token !!}';
        var block_id = '{!! \App\Http\Controllers\FacebookController::$block_id_guitin !!}';
        var app_id = '{!! \App\Http\Controllers\FacebookController::$app_id !!}';
        var noidung = '';
        var index_gui = 0;
        var array_gui = [];
        var btn_gui = $('#bnt_gui');
        var thoigiancho=3000;

        btn_gui.click(function () {
            index_gui=0;
            array_gui=[];
            btn_gui.html("<i class='fa fa-spin fa-refresh'></i> Đang gửi tin...");
            noidung = $('#noidungchinh').val();
            //Nạp danh sách khách hàng
            array_gui=table.rows('.selected').data();
            if($('.chedoguitin:checked').val()=='tatca'){
                array_gui=table.rows().data();
            }

            if(array_gui.length==0){
                alert("Chưa chọn khách hàng nhận!");
                btn_gui.html("<i class='fa fa-send'></i> Gửi tin nhắn");
                return;
            }

            if(!confirm("Dự kiến gửi mất "+array_gui.length*thoigiancho/1000+" giây.\nBạn có chắc muốn gửi???")){
                btn_gui.html("<i class='fa fa-send'></i> Gửi tin nhắn");
                return;
            }

            var guitin = setInterval(function () {
                id_fb = array_gui[index_gui]['id_fb'];
                $.ajax({
                    url: 'https://api.chatfuel.com/bots/' + app_id + '/users/' + id_fb + '/send?chatfuel_token=' + token + '&chatfuel_block_id=' + block_id + '&noidung=' + noidung,
                    type: "POST",
                    data: null,
                    contentType: "application/json; charset=utf-8",
                    success: function (result) {
                        if (result['success']) {
                            $.notify("Gửi thành công (" + index_gui + "/" + array_gui.length + ")", 'success');
                        } else {
                            $.notify('Gửi lỗi tới khách mã ' + array_gui[index_gui], 'error');
                        }
                    },
                    error: function () {
                        $.notify('Gửi lỗi tới khách mã ' + array_gui[index_gui], 'error');
                    }
                });
                index_gui++;
                if (index_gui >= array_gui.length) {
                    clearInterval(guitin);
                    btn_gui.html("<i class='fa fa-check'></i> Gửi hoàn thành!");
                }
            }, thoigiancho)
        })
    </script>
@stop