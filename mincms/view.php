<?php
define( "BASEURL", dirname($_SERVER['PHP_SELF'])."/" );
?>

<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
<meta charset="UTF-8">
<title><?php echo $_GET["file"]?> | minCMS</title>
<link rel="stylesheet" title="Cupertino" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/cupertino/jquery-ui.css">
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("jquery", "1.6");
google.load("jqueryui", "1.7.2");
</script>
<script type="text/javascript" src="<?php echo BASEURL ?>js/slimbox2.js"></script>

<link href='http://fonts.googleapis.com/css?family=Gabriela' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL ?>view.css" /> 
<link rel="stylesheet" href="<?php echo BASEURL ?>css/slimbox2.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo BASEURL ?>view.js"></script> 
<?php if(file_exists("./js/".$_GET["file"] . ".js")){ ?>
<script type="text/javascript" src="<?php echo BASEURL . "js/" . $_GET["file"] . ".js"  ?>"></script> 
<?php } ?>

</head>

<body>

<div id="wrapper">
	<canvas id="canv"></canvas>
</div>
<div id="contents">
<?php
include "markdown.php";

if(!file_exists("./txt/".$_GET["file"] . ".txt")){
	echo "そんなファイルないよ";
}else{
	$my_header = file_get_contents("./txt/header.txt");
	$my_footer = file_get_contents("./txt/footer.txt");
	$my_text = file_get_contents("./txt/". $_GET["file"] . ".txt");
	$my_html = Markdown($my_header.$my_text.$my_footer);
	echo($my_html);
}
?>
</div>
<div id="loginDialog" title="パスワードを入力してください">
パスワード：<input id="password" type="password">
</div>

</body>
</html>
