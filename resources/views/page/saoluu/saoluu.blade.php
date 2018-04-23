@extends('page.master')

@section('style')
@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Danh sách sản sao lưu csdl
                    <small>Tất cả</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class= quanli">
                        <button id="loaibotrung" class="btn btn-default btn-sm">
                            <i class="fa fa-recycle"></i>
                            Làm sạch
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p class="text-muted font-13 m-b-30"></p>
                <table id="bang_teptin" class="table table-striped table-bordered jambo_table">
                    <thead>
                    <tr>
                        <th>TT</th>
                        <th>Bản sao lưu</th>
                        <th>Thời gian</th>
                        <th>Kích thước</th>
                        <th>Tải xuống</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<count($files);$i++)
                        <tr>
                            <td>{!! $i !!}</td>
                            <td>{!! $files[$i]['name'] !!}</td>
                            <td>{!! $files[$i]['time'] !!}</td>
                            <td>{!! $files[$i]['size'] !!}</td>
                            <td>
                                <a href="{!! \App\CusstomPHP\AssetFile::fileNOTpublic($files[$i]['name']) !!}"
                                   target="_blank" class="btn btn-default btn-xs">
                                    <i class="fa fa-download"></i>
                                    Tải xuống
                                </a>
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop


@section('script')

@stop