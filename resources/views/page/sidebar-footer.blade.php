<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Cấu hình">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a onclick="$(document).toggleFullScreen();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Toàn màn hình">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a onclick="$('body').hide();setTimeout(function() {var key=1234,input_key='';while(input_key!=key){input_key=prompt('Nhập mã mở khóa:');}$('body').show();},500)"
       data-toggle="tooltip" data-placement="top" title="" data-original-title="Khóa">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="" href="{!! \App\CusstomPHP\CustomURL::route('logout') !!}"
       data-original-title="Đăng xuất">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>