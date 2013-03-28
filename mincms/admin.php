<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
<meta charset="UTF-8">
<title>Uploader</title>
<link href="fileuploader.css" rel="stylesheet" type="text/css">	
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.4");
	google.load("jqueryui", "1.8.1");
</script>
<script src="fileuploader.js" type="text/javascript"></script>
<script>
function createUploader(){
    var uploader = new qq.FileUploader({
        element: document.getElementById('file-uploader'),
        action: 'up.php',
        debug: true,
	    onComplete: function(id, fileName, responseJSON){
			$('#mp3file').val(fileName);
		}
    });
}
window.onload = createUploader;
</script>

<script type="text/javascript">
$(document).ready(function(){
var dialogOpts = {
      modal: true,
      bgiframe: true,
      autoOpen: false,
      height: 500,
      width: 500,
      draggable: true,
      resizeable: true,
   };
$("#example").dialog(dialogOpts);   //end dialog
   $('#showdialog').click(
      function() {
         $("#example").load("filelist.php", [], function(){
               $("#example").dialog("open");
            } 
         );
         return false;
      }
   );
});
</script>

</head>

<body>
<div id="example"></div>
<a href="" id="showdialog">Open FileList</a>
<div id="file-uploader"></div>
</body>
</html>