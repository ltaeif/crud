<?php
/**
 * Created by PhpStorm.
 * User: Abdellatif
 * Date: 02/07/2015
 * Time: 18:25
 */
?>

<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

<script src="bootstrap/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.iframe-transport.js"></script>
<script src="bootstrap/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload-process.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload-image.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload-audio.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload-video.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="bootstrap/blueimp-file-upload/js/jquery.fileupload-ui.js"></script>


<script src="bootstrap/blueimp-file-upload/blueimp-js/jquery.blueimp-gallery.min.js"></script>

<link href="bootstrap/blueimp-file-upload/css/jquery.fileupload.css" rel="stylesheet" >
<link href="bootstrap/blueimp-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" >
<link href="bootstrap/blueimp-file-upload/css/style.css" rel="stylesheet" >
<link href="bootstrap/blueimp-file-upload/css/blueimp-gallery.min.css" rel="stylesheet" >



<script>

    $(function () {
        'use strict';

        //'<?=baseUrl().'/'.'uploader/uploader.php'?>'

        $('#fileupload').fileupload({
            url: '<?=baseUrl().'/'.'uploader/?dir='.'albums';?>',

            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = data.context.find(':input').serializeArray();
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

        if (window.location.hostname === 'blueimp.github.io') {
            // Demo settings:
            $('#fileupload').fileupload('option', {
                url: '<?=baseUrl().'/'.'uploader/'?>',
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                maxFileSize: 999000,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i
            });
            // Upload server status check for browsers with CORS support:
            if ($.support.cors) {
                $.ajax({
                    url: '<?=baseUrl().'/'.'uploader/?dir=albums';?>',
                    type: 'HEAD'
                }).fail(function () {
                    $('<div class="alert alert-danger"/>')
                        .text('Upload server currently unavailable - ' +
                        new Date())
                        .appendTo('#fileupload');
                });
            }
        } else {
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
            });
        }



    });


</script>




<form id="fileupload" action="<?=baseUrl().'/uploader/uploader.php'?>" method="POST" enctype="multipart/form-data">
    <div >
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->

        <div class="row fileupload-buttonbar" >
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
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade" style="  margin-left: 10px;">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
        <div>
</form>
<br>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Demo Notes</h3>
    </div>
    <div class="panel-body">
        <ul>
            <li>The maximum file size for uploads in this demo is <strong>999 KB</strong> (default file size is unlimited).</li>
            <li>Only image files (<strong>JPG, GIF, PNG, PDF</strong>) are allowed in this demo (by default there is no file type restriction).</li>

            <li>You can <strong>drag &amp; drop</strong> files from your desktop .</li>

        </ul>
    </div>
</div>
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
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
		<td>
		<label class="title">
			<span>Title:</span><br>
			<input name="title[]" class="form-control">
		</label>
		<label class="description">
			<span>Description:</span><br>
			<input name="description[]" class="form-control">
			<input type="hidden" name="dirdemande" value="albums">
			<input type="hidden" name="urldemande" value="<?=baseUrl()?>">

		</label>
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
			<p class="title"><strong>{%=file.title||''%}</strong></p>
			<p class="description">{%=file.description||''%}</p>

			<input type="hidden" name="dirdemande" value="albums">
			<input type="hidden" name="urldemande" value="<?=baseUrl()?>">


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
        <td >
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
    </tr>
{% } %}
</script>