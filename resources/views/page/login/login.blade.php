<html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Đăng nhập hệ thống</title>

    {!! \App\CusstomPHP\AssetFile::css('bootstrap.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('app.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('font-awesome.min.css') !!}
    {!! \App\CusstomPHP\AssetFile::css('custom.css') !!}
</head>

<body class="login" style="background-color: white">
<div>

    <div class="login_wrapper">
        <div class="login_form">
            <section class="login_form_content">
                <form method="post" action="{!! \App\CusstomPHP\CustomURL::route('login') !!}" class="text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <h1 style="font-size: 30px; margin-bottom: 25px">Đăng nhập hệ thống</h1>
                    <div class="input_login">
                        <input name="username" type="text" autocomplete="off" class="form-control" placeholder="Tên đăng nhập" required="">
                    </div>
                    <div  class="input_login">
                        <input name="password" type="password" autocomplete="off" class="form-control" placeholder="Mật khẩu" required="">
                    </div>
                    <div>
                        <button name="submit" class="btn btn-primary submit pull-right">Đăng nhập</button>
                    </div>

                    <div class="clearfix"></div>
                </form>
            </section>

        </div>
    </div>
</div>


{!! \App\CusstomPHP\AssetFile::js('jquery.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('bootstrap.min.js') !!}
{!! \App\CusstomPHP\AssetFile::js('app.js') !!}
{!! \App\CusstomPHP\AssetFile::js('notify/notify.js') !!}
<script>
    $(document).ready(function () {
        $('#myModal').modal('show');
    })
</script>
@if(Session::has('message_login'))
    <script>
        $.notify('{!! Session::get('message_login') !!}','error');
    </script>
@endif
</body>
</html>