@extends('layouts.admin')
@section('title', 'Tạo sản phẩm')
@section('content')
    <div class="row">
        <product-form-component></product-form-component>
    </div>
@endsection
@push('styles')
{{--    <link href="{{asset('assets/admin/css/lfm.css')}}" rel="stylesheet" type="text/css" />--}}
@endpush
@push('scripts')
    <script src="{{asset('assets/admin/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        var categories = JSON.parse('<?php echo json_encode($categories) ?>');
        var publicStatus = JSON.parse('<?php echo json_encode(Constants::NEWS_PUBLIC_STATUS) ?>');
        var newsId = '{{isset($id) ? $id : ''}}';
        $(document).ready(function () {
            if($(".editor").length > 0){
                var editor_config = {
                    path_absolute : "/",
                    selector: ".editor",
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons template paste textcolor colorpicker textpattern"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                    relative_urls: false,
                    file_browser_callback : function(field_name, url, type, win) {
                        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                        if (type === 'image') {
                            cmsURL = cmsURL + "&type=Images";
                        } else {
                            cmsURL = cmsURL + "&type=Files";
                        }

                        tinyMCE.activeEditor.windowManager.open({
                            file : cmsURL,
                            title : 'Filemanager',
                            width : x * 0.8,
                            height : y * 0.8,
                            resizable : "yes",
                            close_previous : "no"
                        });
                    }
                };

                tinyMCE.init(editor_config);

                $('form').parsley();
            }
        });
    </script>
@endpush
