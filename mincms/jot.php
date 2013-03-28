<?php
//*********************************
//             J O T
//*********************************
//MIT License

define( "BASEURL", dirname($_SERVER['PHP_SELF'])."/" );
define("PASSWORD", "test");
session_start();
if(isset($_SESSION["TEST"]) && $_SESSION["TEST"] != null && md5(PASSWORD) === $_SESSION["TEST"]){
}else{
	session_destroy();
	print "ログインしていません。";
	exit;
}

$file = $_GET["file"];
if(!isset($file)){
	$file = "data.txt";
}

$path_parts = pathinfo($file);
$ext = $path_parts['extension'];

switch( $ext ){
case "txt":
	$file = "./txt/".$file;
	break;
case "css":
	break;
case "js":
	$file = "./js/".$file;
	break;
default:
	//nothing
}

// ファイルを保存
if ($_POST['save']) {
	touch($file);
    $fp = @fopen($file, 'w');
    if (!$fp) print "このファイルには書き込みできません。";
    else {
//        $contents = htmlspecialchars($_POST['contents']);
		//markdown内にHTMLタグを使うため、エスケープロジックは削除
        $contents = $_POST['contents'];
		$contents = str_replace('\\"', '"', $contents);
		$contents = str_replace("\\'", "'", $contents);
        fwrite($fp, $contents);
        fclose($fp);
        echo "書き込み完了しました。";
		echo "最終更新日".date("(Y/m/d H:i)");
    }
	exit();
}

// ファイルを読み込み
if ($_POST['load']) {
	$text = "";
	if (file_exists($file)) {
		$text = file_get_contents($file);
//markdown内にHTMLタグを使うため、エスケープロジックは削除
//		$text = htmlspecialchars($text);
	}
	echo $text;
	exit();
}

//最終更新日を取得
if ($_POST['mdate']) {
	$ret = "* 新規 *";
	if (file_exists($file)) {
		$mod = filemtime($file);
		//$ret = "最終更新日".date("(Y/m/d H:i)",$mod);
		$ret = "";
	}
	echo $ret;
	exit();
}

?>
<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
<title>Minimalism</title>
<meta charset="UTF-8" />
<style type="text/css">
#status{
	font-size: 80%;
}
body{
	background: #eeeeee;
}

textarea{
	border: 1px solid #eeeeee;
}

.menuButton{
	float: left;
	width: 50%;
	height: 16px;
	font-size: 80%;
	text-align: center;
	background: #000;
	color: #DDC;
}


.menuButtonDisabled{
	background: #AAA;
}

.menuButtonActive{
	background: #611;
}

#container{
	width: 450px;
	margin: auto;
}

#contents{
	width: 450px;
	margin: 0;
	padding: 0;
	border: 0px;
	-moz-tab-size:4; -o-tab-size:4; -webkit-tab-size:4; tab-size:4;

}



</style>
<link href="<?php echo BASEURL ?>fileuploader.css" rel="stylesheet" type="text/css">	
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.4.2");
	google.load("jqueryui", "1.8.1");
</script>
<script type="text/javascript" src="<?php echo BASEURL ?>js/jquery.hotkeys-0.7.9.min.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>js/jquery.textarea.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>fileuploader.js"></script>

<script type="text/javascript">

var fore = "";
var saved = true;

function checkChange(){
	var now = $("#contents").val();
	if(fore == now){
		$("#save").addClass("menuButtonDisabled");
		saved=true;
	}else{
		$("#save").removeClass("menuButtonDisabled");
		saved=false;
	}
}

function load(){
	$.post(document.URL,{ load: "true"}, function(data){
		$("#contents").val(data);
		fore = $("#contents").val();
		$("#contents").focus();
	})
	$.post(document.URL,{ mdate: "true"}, function(data){
		$("#status").text(data);
	})
	return(false);
}

function statusClear(){
	$("#status").css('background', '#ffffff');
	$("#save").removeClass("menuButtonActive");
}

function createUploader(){
    var uploader = new qq.FileUploader({
        element: document.getElementById('file-uploader'),
        action: '<?php echo BASEURL ?>up.php',
        debug: true,
	    onComplete: function(id, fileName, responseJSON){
			$('#mp3file').val(fileName);
		}
    });
}

function save(){
	var v = $("#contents").val();
	$("#save").addClass("menuButtonActive");
	$.post(document.URL,{ save: "true", contents: v}, function(data){
		$("#status").text(data);
		$("#status").css('background', '#ddddff');
		setTimeout("statusClear()", 200);
	});
	fore = $("#contents").val();
	saved=true;
	return(false);
}

$(function(){
	load();
	setInterval(checkChange, 1000);
	$("#save").addClass("menuButtonDisabled");
	$("#reload").click(load);
	$("#save").click(save);
	$("#contents").tabby();
	createUploader();
	var dialogOpts = {
	      modal: true,
	      bgiframe: true,
	      autoOpen: false,
	      height: 500,
	      width: 500,
	      draggable: true,
	      resizeable: true,
	   };
	$("#filelist").dialog(dialogOpts);   //end dialog
	$('#showdialog').click(
	  function() {
	     $("#filelist").load("<?php echo BASEURL ?>filelist.php", [], function(){
	           $("#filelist").dialog("open");
	        } 
	     );
	     return false;
	  }
	);

});

$(document).bind('keydown', 'Ctrl+s', function(evt){ return( save() ); } );
$(document).bind('keydown', 'Ctrl+r', function(evt){ return( load() ); } );
</script>
</head>
<body>
<a href="<?php echo BASEURL ?>jot.php?file=view.css">Edit CSS</a>
<div id="container">
<form>
<div style="overflow: auto">
	<div id="save" class="menuButton">Save(Ctrl+S)</div>
	<div id="reload" class="menuButton">Reload(Ctrl+R)</div>
</div>
<textarea id="contents" name="contents" cols="60" rows="40" onChange="saved=false">
</textarea>
</form>
<span id="changed"></span><span id="status"></span>
<p><a href="./">View HTML</a></p>
</div>
<div id="filelist"></div>
<button id="showdialog">Open FileList</button>
<div id="file-uploader"></div>
</body>
</html>
