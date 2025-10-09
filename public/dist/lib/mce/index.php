<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="icon" href="dk.png">
  	<title>Dewan Komputer - Tinymce WYSIHTML5</title>
  	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"></link>
</head>
<body>
	<nav class="navbar navbar-dark bg-success fixed-top">
	  <a class="navbar-brand" href="index.php" style="color: #fff;">
	    Dewan Komputer
	  </a>
	</nav>

	<div class="container mb-3">
		<h2 align="center" style="margin: 70px 10px 10px 10px;">Tinymce WYSIHTML5</h2><hr>

		<div class="mb-3">
			<h3>Default Tinymce</h3>
			<textarea name="default" id="default"></textarea>
		</div><hr>

		<div class="mb-3" style="margin-bottom: 100px;">
			<h3>Custom 1 Tinymce</h3>
			<textarea name="custom1" id="custom1"></textarea>
		</div>

    <div class="mb-3" style="margin-bottom: 100px;">
      <h3>Custom 2 Tinymce (Upload Images)</h3>
      <textarea name="custom2" id="custom2"></textarea>
    </div>
	</div>

  <div class="navbar bg-dark">
    <div style="color: #fff;">© <?php echo date('Y'); ?> Copyright:
        <a href="https://dewankomputer.com/"> Dewan Komputer</a>
    </div>
  </div>

	<script src="tinymce/tinymce.min.js"></script>
	<script>
    tinymce.init({ selector:'#default', });
  </script>
  <script type="text/javascript">
    tinymce.init({
        selector: '#custom1',
        height: 400,
        forced_root_block : "",
        force_br_newlines : true,
        force_p_newlines : false,
        plugins: [
          'autolink lists link image charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime media nonbreaking save table contextmenu directionality',
          'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect table | bold italic | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media ',
        toolbar2: 'print preview | forecolor backcolor emoticons | fontselect | fontsizeselect | codesample code fullscreen',
        templates: [
          { title: 'Test template 1', content: '' },
          { title: 'Test template 2', content: '' }
        ],
        content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
        ],
      });

        tinymce.init({
        selector: '#custom2',
        height: 400,
        file_browser_callback_types: 'file image media',
        file_picker_types: 'file image media',
        forced_root_block : "",
        force_br_newlines : true,
        force_p_newlines : false,
        plugins: [
          'autolink lists link image charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime media nonbreaking save table contextmenu directionality',
          'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect table | bold italic | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media ',
        toolbar2: 'print preview | forecolor backcolor emoticons | fontselect | fontsizeselect | codesample code fullscreen',
        templates: [
          { title: 'Test template 1', content: '' },
          { title: 'Test template 2', content: '' }
        ],
        content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
        ],

        images_upload_url: 'uploadtiny.php',
        images_upload_handler: function (blobInfo, success, failure) {
          var xhr, formData;
        
          xhr = new XMLHttpRequest();
          xhr.withCredentials = false;
          xhr.open('POST', 'uploadtiny.php');
        
          xhr.onload = function() {
              var json;
          
              if (xhr.status != 200) {
                  failure('HTTP Error: ' + xhr.status);
                  return;
              }
          
              json = JSON.parse(xhr.responseText);
          
              if (!json || typeof json.location != 'string') {
                  failure('Invalid JSON: ' + xhr.responseText);
                  return;
              }
          
              success(json.location);
          };
        
          formData = new FormData();
          formData.append('file', blobInfo.blob(), blobInfo.filename());
          xhr.send(formData);
      },
      });
  </script>
</body>
</html>