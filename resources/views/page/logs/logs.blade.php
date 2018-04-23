@extends('page.master')

@section('style')
    {!! \App\CusstomPHP\AssetFile::css('daterangepicker.css') !!}
@stop


@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Danh sách bản ghi lịch sử hệ thống
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-12">
                    @foreach($logs as $item)
                    <div class="alert alert-success">
                        <strong>{!! $item->ngaytao !!}</strong>{!! $item->message !!}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop


@section('script')@stop