@extends('backpack::layout')

@section('content')
    @include('inc.jquery_file_upload')


@endsection
 

@section('after_styles')
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload-ui.css') }}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload-noscript.css') }}"></noscript>
    <noscript><link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css') }}"></noscript>
@endsection

@section('after_scripts')
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <!--<script src="/js/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
    <!-- blueimp Gallery script -->
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/js/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <script type="text/JavaScript">
        
        $(function () {
            'use strict';

            // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: '/fileupload/handle/{{ $objtype }}/{{ $objid }}'
            });

            // Enable iframe cross-domain access via redirect option:
            $('#fileupload').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );


            // Load existing files:
            $('#fileupload').addClass('fileupload-processing');
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: $('#fileupload').fileupload('option', 'url'),
                dataType: 'json',
                context: $('#fileupload')[0]
            }).always(function () {
                $(this).removeClass('fileupload-processing');

            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
              
                if ($("#fileupload .sortable").find('tr').size() > 0) {
                    enableSorting();
                }

                $(".template-download .btn.edit").click(function(){

                    $("#editModal .filename").val($(this).data('filename'));
                    $("#editModal").modal("show");
                })

            });

            //Binding callback
            $("#fileupload").bind('fileuploadchange', function(){
                disableSorting();
            });

            $("#fileupload").bind('fileuploaddone', function(){
                enableSorting();
            });

            $("#fileupload .saveorder").click(function(){
                var fileorders = [];

                $("#fileupload .files tr").each(function(){
                    fileorders.push($(this).find('.name').find('a').attr('title'));
                });

                //console.log(fileorders);

                $.ajax({
                    url: '/fileupload/saveorder/{{ $objtype }}/{{ $objid }}',
                    type: 'post',
                    data: {
                        fileorders: fileorders,
                    },
                    dataType: 'JSON',
                    success: function (result) {
                        if (result.success) {
                            alert("Order is saved");
                        }
                    },
                    error: function () {
                        alert('Failed.');
                    }
                }); 
            });



            $("#editModal .modal-footer .btn-success").click(function(){
                console.log($("#editModal .modal-body form").serializeArray()); 
                
                $.ajax({
                    url: '/fileupload/saveextra/{{ $objtype }}/{{ $objid }}',
                    type: 'post',
                    data: {
                        extra: $("#editModal .modal-body form").serializeArray(),
                    },
                    dataType: 'JSON',
                    success: function (result) {
                        if (result.success) {
                            alert("Data is saved");
                        }
                    },
                    error: function () {
                        alert('Failed.');
                    }
                }); 
            })
        });

        function enableSorting()
        {
            $("#fileupload .sortable").sortable({
                items: "tr:not(.template-upload)",
                placeholder: "ui-state-highlight",
                // stop: function(event, ui){
                    
                // }
            });
            $("#fileupload .saveorder").removeClass('hidden');
        }

        function disableSorting()
        {
            $("#fileupload .saveorder").addClass('hidden');
        }

    </script>   
@endsection 