    <div class="">
        <!-- The file upload form used as target for the file upload widget -->
        <form id="fileupload" method="POST" enctype="multipart/form-data">
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Add files...</span>
                        <input type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel upload</span>
                    </button>
                    <button type="button" class="btn btn-danger delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" class="toggle">
                    <button type="button" class="btn btn-success saveorder hidden">
                        <i class="glyphicon glyphicon-th-list"></i>
                        <span>Save Order</span>
                    </button>
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files sortable"></tbody></table>
        </form>
        
    </div>
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <!-- Modal -->
    <div id="editorModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Preference</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" class="form-control filename" name="filename"/>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control title" name="title"/>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control desc" name="desc"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Live</label>
                                <select class="form-control live" name="live">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
            </div>

        </div>
    </div>

    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                </span>
            </td>
            <td>
                <p class="name">
                    {% if (file.url) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    {% } else { %}
                        <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                <button type="button" class="btn btn-primary edit" data-filename="{%=file.name%}" onClick="editExtras($(this)); return false;">
                    <i class="glyphicon glyphicon-edit"></i>
                    <span>Edit</span>
                </button>

                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
            <td class="extra hidden">
                <span class="title">{%=file.title%}</span>
                <span class="desc">{%=file.desc%}</span>
                <span class="live">{%=file.live%}</span>
            </td>

        </tr>
    {% } %}
    </script>


@section('jquery_file_uploader_after_styles') 
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload-ui.css') }}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload-noscript.css') }}"></noscript>
    <noscript><link rel="stylesheet" href="{{ asset('js/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css') }}"></noscript>
@endsection

@section('jquery_file_uploader_after_scripts')
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
                url: '/fileupload/handle/{{ $entity_name }}/{{ $entity_id }}'
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

            });

            //Binding callback
            $("#fileupload").bind('fileuploadchange', function(){
                disableSorting();
            });

            $("#fileupload").bind('fileuploaddone', function(){
                enableSorting();
            });

            $("#fileupload .saveorder").click(function(){
                saveorder();
            });


            $("#editorModal .modal-footer .btn-success").click(function(){
                saveextras();
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

        function saveorder()
        {
            var fileorders = [];

            $("#fileupload .files tr").each(function(){
                fileorders.push($(this).find('.name').find('a').attr('title'));
            });

            //console.log(fileorders);
            $.ajax({
                url: '/fileupload/saveorder/{{ $entity_name }}/{{ $entity_id }}',
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

        }

        function saveextras()
        {
            var formData = $("#editorModal .modal-body form").serializeArray();
            var filename = formData[0]['value'];
            //console.log(formData);
            var tdExtra = $("button[data-filename='" + filename + "']").parent().siblings('td.extra');
            //console.log(tdExtra);

            for(var i = 1; i < formData.length; i++) {
                tdExtra.find('.' + formData[i]['name']).text(formData[i]['value']);
            }
            
            $.ajax({
                url: '/fileupload/saveextras/{{ $entity_name }}/{{ $entity_id }}',
                type: 'post',
                data: {
                    extras: $("#editorModal .modal-body form").serializeArray(),
                },
                dataType: 'JSON',
                success: function (result) {
                    if (result.success) {
                        alert("Data is saved");
                        $("#editorModal").modal('toggle');
                    }else{
                        alert(result.error);
                    }
                },
                error: function () {
                    alert('Failed.');
                }
            }); 

        }

        function editExtras(button)
        {
            $("#editorModal .filename").val(button.data('filename'));
            var tdExtra = button.parent().siblings('td.extra');
            
            $("#editorModal .title").val(tdExtra.find('.title').text());
            $("#editorModal .desc").val(tdExtra.find('.desc').text());
            $("#editorModal .live").val(tdExtra.find('.live').text());
            //$("#editorModal .title").val($(this).parent().siblings('.extra').find('.title').text());
            $("#editorModal").modal("show");

        }
    </script>   
@endsection    