@extends('page.master')

@section('style')

@stop


@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{!! \App\CusstomPHP\CustomURL::route('luu-cauhinh') !!}" method="post">
                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                    <label>Mẫu hóa đơn:</label>
                    <textarea name="hoadon_template" id="hoadon_template">
                        {!! \App\CusstomPHP\Cauhinhs::getCauHinh('hoadon_template') !!}
                    </textarea>
                    <hr>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    {!! \App\CusstomPHP\AssetFile::js('tinymce/tinymce.min.js') !!}
    <script>
        tinymce.init({
            selector: '#hoadon_template',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
            image_advtab: true
        });
    </script>
@stop