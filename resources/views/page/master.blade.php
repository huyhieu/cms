<!DOCTYPE HTML>
<html @section('offline')@show>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{!! \App\CusstomPHP\AssetFile::file('favicon.ico') !!}">
    <title>@section('title')@show Phần mềm quản lí bán hàng</title>

    {!! \App\CusstomPHP\AssetFile::css('bootstrap.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('app.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('nprogress.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('font-awesome.min.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('dataTables.bootstrap.min.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('fixedHeader.bootstrap.css') !!}
    {!! \App\CusstomPHP\AssetFile::contentCSS('custom.css') !!}
    @section('style')
    @show
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="#" class="site_title"><i class="fa fa-envira"></i> <span>Ekata</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="https://colorlib.com/polygon/gentelella/images/img.jpg" alt="..."
                             class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Chào mừng,</span>

                        <h2>{!! \App\CusstomPHP\CurrentUser::name() !!}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br>

                <!-- sidebar menu -->
                @include('page.sidebar')
                        <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                @include('page.sidebar-footer')
                        <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        @include('page.top-nav')
                <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 1704px;">
            <div class="row">
                @section('content')@show
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('page.footer')
                <!-- /footer content -->
    </div>
</div>

{{--JS--}}
{!! \App\CusstomPHP\AssetFile::js('jquery.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('ajax_process.js') !!}
{!! \App\CusstomPHP\AssetFile::js('nprogress.js') !!}
<script>
    var level_quanli=false;
    function kiemtraquanli(){
        if('{!! \App\Http\Controllers\NhanVienController::$NHANVIEN !!}'=='{!! \App\CusstomPHP\CurrentUser::levelTT() !!}'){
            $('.quanli').remove();
        }else{
            level_quanli=true;
            $('.quanli').show();
        }
    }
    $(document).ready(function () {
        kiemtraquanli();
    })
</script>
{!! \App\CusstomPHP\AssetFile::js('bootstrap.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('app.js') !!}
{!! \App\CusstomPHP\AssetFile::js('notify/notify.js') !!}
{!! \App\CusstomPHP\AssetFile::js('AutoNumber/autoNumeric.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('md5.js') !!}
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
{!! \App\CusstomPHP\AssetFile::js('datatable/dataTables.select.min.js') !!}

{!! \App\CusstomPHP\AssetFile::js('datetime/moment.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('JsBarcode/JsBarcode128.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('JsBarcode/download.js') !!}
{!! \App\CusstomPHP\AssetFile::js('daterangepicker/daterangepicker.js') !!}
<script>
    //Cấu hình tiền
    //khởi tạo giá trị tiền tệ
    $('.tien-input').autoNumeric('init', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        currencySymbol: ' đ',
        currencySymbolPlacement: 's',
        maximumValue: '99999999999999',
        minimumValue: '-99999999999999'
    });
    function reloadTien() {
        var tien = $('.tien');
        tien.autoNumeric('destroy');
        tien.autoNumeric('init', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            currencySymbol: ' đ',
            currencySymbolPlacement: 's',
            maximumValue: '99999999999999',
            minimumValue: '-99999999999999'
        });
    }
    //Kiểm tra mạng
    setInterval(function () {
        if(!navigator.onLine){
            $.notify('Mất kết nối mạng!','warn');
        }
    },5000);
</script>

@section('script')@show
{{--/JS--}}

</body>
</html>