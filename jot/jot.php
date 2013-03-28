<?php
//*********************************
//             J O T
//*********************************
//MIT License

$file = $_GET["file"];
if(!isset($file)){
	$file = "data.txt";
}

// ファイルを保存
if ($_POST['save']) {
	touch($file);
    $fp = @fopen($file, 'w');
    if (!$fp) print "このファイルには書き込みできません。";
    else {
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
	}
	echo $text;
	exit();
}

//最終更新日を取得
if ($_POST['mdate']) {
	$ret = "* 新規 *";
	if (file_exists($file)) {
		$mod = filemtime($file);
		$ret = "";
	}
	echo $ret;
	exit();
}

?>
<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
<title>JOT</title>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="//cachedcommons.org/cache/jquery-hotkeys/0.0.0/javascripts/jquery-hotkeys.js"></script>
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
		$("#contents").bind('keydown', 'ctrl+s', function(evt){ return save(); } );
		$("#contents").bind('keydown', 'Ctrl+r', function(evt){ return load(); } );
	});

</script>
</head>
<body>
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
</div>
</body>
</html>
