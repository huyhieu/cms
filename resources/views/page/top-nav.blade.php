<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="https://colorlib.com/polygon/gentelella/images/img.jpg" alt="">
                        {!! \App\CusstomPHP\CurrentUser::name() !!}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href=""> Thông tin</a></li>
                        <li>
                            <a href="#">
                                <span>Cài đặt</span>
                            </a>
                        </li>
                        <li><a target="_blank" href="https://www.messenger.com/t/huyhieu2612">Trợ giúp</a></li>
                        <li><a href="{!! \App\CusstomPHP\CustomURL::route('logout') !!}">
                                <i class="fa fa-sign-out pull-right"></i> Đăng xuất</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>