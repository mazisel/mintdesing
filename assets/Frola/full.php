<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/froala_editor.css">
  <link rel="stylesheet" href="css/froala_style.css">
  <link rel="stylesheet" href="css/plugins/code_view.css">
  <link rel="stylesheet" href="css/plugins/draggable.css">
  <link rel="stylesheet" href="css/plugins/colors.css">
  <link rel="stylesheet" href="css/plugins/emoticons.css">
  <link rel="stylesheet" href="css/plugins/image_manager.css">
  <link rel="stylesheet" href="css/plugins/image.css">
  <link rel="stylesheet" href="css/plugins/line_breaker.css">
  <link rel="stylesheet" href="css/plugins/table.css">
  <link rel="stylesheet" href="css/plugins/char_counter.css">
  <link rel="stylesheet" href="css/plugins/video.css">
  <link rel="stylesheet" href="css/plugins/fullscreen.css">
  <link rel="stylesheet" href="css/plugins/file.css">
  <link rel="stylesheet" href="css/plugins/quick_insert.css">
  <link rel="stylesheet" href="css/plugins/help.css">
  <link rel="stylesheet" href="css/third_party/spell_checker.css">
  <link rel="stylesheet" href="css/plugins/special_characters.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

  <style>
      body {
          text-align: center;
      }

      div#editor {
          width: 81%;
          margin: auto;
          text-align: left;
      }

      .ss {
        background-color: red;
      }
  </style>
</head>

<body>
   <div id="editor">  
        <textarea id='edit'></textarea>
  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <script type="text/javascript" src="js/froala_editor.min.js" ></script>
  <script type="text/javascript" src="js/plugins/align.min.js"></script>
  <script type="text/javascript" src="js/plugins/char_counter.min.js"></script>
  <script type="text/javascript" src="js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="js/plugins/file.min.js"></script>
  <script type="text/javascript" src="js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="js/plugins/image.min.js"></script>
  <script type="text/javascript" src="js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="js/plugins/link.min.js"></script>
  <script type="text/javascript" src="js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="js/plugins/quick_insert.min.js"></script>
  <script type="text/javascript" src="js/plugins/quote.min.js"></script>
  <script type="text/javascript" src="js/plugins/table.min.js"></script>
  <script type="text/javascript" src="js/plugins/save.min.js"></script>
  <script type="text/javascript" src="js/plugins/url.min.js"></script>
  <script type="text/javascript" src="js/plugins/video.min.js"></script>
  <script type="text/javascript" src="js/plugins/help.min.js"></script>
  <script type="text/javascript" src="js/plugins/print.min.js"></script>
  <script type="text/javascript" src="js/third_party/spell_checker.min.js"></script>
  <script type="text/javascript" src="js/plugins/special_characters.min.js"></script>
  <script type="text/javascript" src="js/plugins/word_paste.min.js"></script>
  <script type="text/javascript" src="js/languages/tr.js"></script>


  <script>
    $.FroalaEditor.DefineIcon('my_dropdown', {NAME: 'code'});
    $.FroalaEditor.RegisterCommand('my_dropdown', {
      title: 'Cod Ekle',
      type: 'dropdown',
      focus: false,
      undo: false,
      refreshAfterCallback: true,
      options: {
        'v1': 'Php',
        'v2': 'Html',
        'v3': 'CSS'

      },
      callback: function (cmd, val) {
        if (val=="v1") {
          this.html.insert('[PHPX][/PHPX]');
        }
        if (val=="v2") {
          this.html.insert('[HTMLX][/HTMLX]');
        }
        if (val=="v3") {
          this.html.insert('[CSSX][/CSSX]');
        }
      },     
      // Callback on refresh.
      refresh: function ($btn) {
        console.log ('do refresh');
      },
      // Callback on dropdown show.
      refreshOnShow: function ($btn, $dropdown) {
        console.log ('do refresh when show');
      }, 
    });

    $.FroalaEditor.DefineIcon('diger', {NAME: 'cog'});
    $.FroalaEditor.RegisterCommand('diger', {
      title: 'Diğer',
      type: 'dropdown',
      focus: false,
      undo: false,
      refreshAfterCallback: true,
      options: {
        'v1': 'alt',
        'v2': 'ust'


      },
      callback: function (cmd, val) {
        if (val=="v1") {
          this.html.insert('[PHPX][/PHPX]');
        }
        if (val=="v2") {
          this.html.insert('[HTMLX][/HTMLX]');
        }

      },     
      // Callback on refresh.
      refresh: function ($btn) {
        console.log ('do refresh');
      },
      // Callback on dropdown show.
      refreshOnShow: function ($btn, $dropdown) {
        console.log ('do refresh when show');
      }, 
    });

    $(function(){

      $('#edit').froalaEditor({
        language: 'tr',
        imageUploadURL: 'islem.php',
        imageUploadParams: {    id: 'my_Editor'   },
        imageDeleteURL: 'delete_image.php',
        imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL'],
        videoInsertButtons: ['videoBack', '|', 'videoByURL', 'videoEmbed'],
        heightMin: 300,
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineClass', 'clearFormatting', '|', 'emoticons', 'fontAwesome', 'specialCharacters',  'lineHeight', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '|', 'insertLink', 'insertImage', 'insertVideo',  'insertHR', 'getPDF', 'print', 'help', 'html', 'fullscreen', '|', 'undo', 'redo','my_dropdown']
        

       })

    });

    /*
     imageUpload: true,
        // Set the image upload parameter.
        imageUploadParam: 'file',

        // Set the image upload URL.
        imageUploadURL: 'islem.php',

        // Additional upload params.
        imageUploadParams: {class: 'fedit'},

        // Set request type.
        imageUploadMethod: 'POST',

        // Set max image size to 5MB.
        imageMaxSize: 5 * 1024 * 1024,

        // Allow to upload PNG and JPG.
        imageAllowedTypes: ['jpeg', 'jpg', 'png']
        
    */
  </script>

  <script>
  $(function() {
    // Catch the image being removed.
    $('#edit').on('froalaEditor.image.removed', function (e, editor, $img) {
      //alert($img.attr('src'));
      $.ajax({
        // Request method.
        method: 'POST',
 
        // Request URL.
        url: 'delete_image.php',
 
        // Request params.
        data: {
          src: $img.attr('src')
        }
      })
      .done (function (data) {
        //alert('Image was deleted');
      })
      .fail (function (err) {
        //alert('Image delete problem: ' + JSON.stringify(err));
      })
    });
  });
</script>
</body>
</html>