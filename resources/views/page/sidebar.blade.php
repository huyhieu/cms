<ul>
    <li>
        <a href="{!! \App\CusstomPHP\CustomURL::route('get-trangchu') !!}">
            <i class="fa fa-home"></i>
            <span>Trang chủ</span>
        </a>
    </li>
    <li class="quanli">
        <a href="{!! \App\CusstomPHP\CustomURL::route('get-chinhanh') !!}">
            <i class="fa fa-location-arrow"></i>
            <span>Chi nhánh</span>
        </a>
    </li>
    <li class="quanli">
        <a href="{!! \App\CusstomPHP\CustomURL::route('get-nhanvien') !!}">
            <i class="fa fa-user"></i> <span>Nhân viên</span>
        </a>
    </li>
    <li class="quanli dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-shopping-bag"></i> <span>Hàng hóa</span></a>
        <ul class="dropdown-menu">
            <li class="quanli"><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('getxuatkho-chuyenhang') !!}">Xuất kho</a></li>
            <li class="quanli"><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('nhapkho-nhaphang') !!}">Nhập kho</a></li>
            <li class="quanli"><a href="{!! \App\CusstomPHP\CustomURL::route('get-nhaphang') !!}">Nhập hàng mới</a></li>
            <li class="quanli"><a href="{!! \App\CusstomPHP\CustomURL::route('get-doigia') !!}">Đổi giá nâng cao</a></li>
            <li><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('get-chuyenhang') !!}">Chuyển hàng</a></li>
            <li><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('get-dathang') !!}">Thông tin đặt hàng</a></li>
            <li><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('getLichsu-chuyenhang') !!}">Lich sử chuyển hàng</a></li>
            <li class="quanli">
                <a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('getLichSu-nhaphang') !!}"> Lịch sử nhập kho</a></li>
            <li><a href="{!! \App\CusstomPHP\CustomURL::route('getView-sanpham') !!}">Tất cả hàng hóa</a></li>
        </ul>
    </li>
    <li class="quanli dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-list-alt"></i> <span>Hóa đơn</span></a>
        <ul class="dropdown-menu">
            <li><a href="{!! \App\CusstomPHP\CustomURL::route('tongquan-hoadon') !!}">Tổng hợp hóa đơn</a></li>
            <li><a href="{!! \App\CusstomPHP\CustomURL::route('get-hoadon') !!}">Quản lí hóa đơn</a></li>
            <li><a href="{!! \App\CusstomPHP\CustomURL::route('hanghoa-hoadon') !!}">Hàng hóa đơn</a></li>
        </ul>
    </li>
    <li class="quanli dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-users"></i>
            <span>Khách hàng</span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{!! \App\CusstomPHP\CustomURL::route('main-khachang') !!}">Danh sách khách hàng</a>
            </li>
            <li class="quanli"><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('main-khachangvoucher') !!}">Danh sách
                    voucher</a>
            </li>
            <li class="quanli"><a style="display: none;" href="{!! \App\CusstomPHP\CustomURL::route('get-sent') !!}">Gửi tin nhắn facebook</a></li>
        </ul>
    </li>
    {{--<li class="quanli dropdown">--}}
        {{--<a class="dropdown-toggle" data-toggle="dropdown" >--}}
            {{--<i class="fa fa-bar-chart-o"></i> <span>Thống kê </span></a>--}}
        {{--<ul class="dropdown-menu">--}}
            {{--<li>--}}
                {{--<a href="{!! \App\CusstomPHP\CustomURL::route('sanpham-banchay-thongke') !!}">Sản phẩm bán chạy</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{!! \App\CusstomPHP\CustomURL::route('sanpham-bancham-thongke') !!}">Sản phẩm bán chậm</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{!! \App\CusstomPHP\CustomURL::route('banhang-thongke') !!}">Thống kê bán hàng</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{!! \App\CusstomPHP\CustomURL::route('khachhang-thongke') !!}">Thống kê khách hàng</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</li>--}}
    <li class="quanli dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-cogs"></i><span>Cấu hỉnh </span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{!! \App\CusstomPHP\CustomURL::route('get-cauhinh') !!}">Cấu hình chung</a>
            </li>
        </ul>
    </li>
    {{--<li class="quanli">--}}
        {{--<a href="{!! \App\CusstomPHP\CustomURL::route('get-saoluu') !!}">--}}
            {{--<i class="fa fa-database"></i>--}}
            {{--<span>Sao lưu</span>--}}
        {{--</a>--}}
    {{--</li>--}}


    <li>
        <a href="{!! \App\CusstomPHP\CustomURL::route('banhang') !!}">
            <i class="fa fa-laptop"></i>
            <span>Bán hàng</span>
        </a>
    </li>

</ul>
