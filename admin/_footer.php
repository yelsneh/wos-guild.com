<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="/js/jquery.form.min.js"></script>
<script src="/js/sortable.min.js"></script>
<script src="/js/bootstrap-colorpicker.min.js"></script>
<script src="/js/bootstrap-tagsinput.min.js"></script>
<script src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.js"></script>







<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/js/file-upload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="/js/file-upload/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/js/file-upload/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="/js/file-upload/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!-- blueimp Gallery script -->
<script src="/js/file-upload/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/js/file-upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/js/file-upload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/js/file-upload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/js/file-upload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/js/file-upload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/js/file-upload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/js/file-upload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/js/file-upload/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="/js/file-upload/main.js"></script>

<script src="/js/froala/js/froala_editor.min.js"></script>
  <!--[if lt IE 9]>
    <script src="/js/froala/js/froala_editor_ie8.min.js"></script>
  <![endif]-->
<script src="/js/froala/js/plugins/video.min.js"></script>
<script src="/js/froala/js/plugins/lists.min.js"></script>
<script src="/js/froala/js/plugins/media_manager.min.js"></script>
<script src="/js/froala/js/plugins/tables.min.js"></script>
<script src="/js/froala/js/plugins/font_family.min.js"></script>
<script src="/js/froala/js/plugins/font_size.min.js"></script>
<script src="/js/froala/js/plugins/file_upload.min.js"></script>
<script src="/js/froala/js/plugins/char_counter.min.js"></script>
<script src="/js/froala/js/plugins/colors.min.js"></script>
<script src="/js/froala/js/plugins/block_styles.min.js"></script>

    <script>
	$(document).ready(function() {
		$('.paginate-table').dataTable();
	});
	$(function(){
        $('.color-picker').colorpicker({
			format: 'hex'	
		});
        $('#edit')
            .editable({
				inlineMode: false,
				theme: "gray",
				imageUploadURL: '/upload_image.php',
				imageDeleteURL: '/delete_image.php',
				imagesLoadURL: '/load_images.php',
				pastedImagesUploadURL: '/upload_image.php',
				buttons: ["html", "undo", "redo", "bold", "italic", "underline",
					"strikeThrough", "subscript", "superscript", "fontSize",
					"formatBlock", "blockStyle", "align",
					"insertOrderedList", "insertUnorderedList", "outdent",
					"indent", "selectAll", "createLink", "insertImage",
					"insertVideo", "table", "insertHorizontalRule"],
			})
      });
	  
	</script>
</body>
</html>
