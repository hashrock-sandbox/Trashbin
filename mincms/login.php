<?php
define("PASSWORD", "test");
session_start();
$login = "failed";
$message = "Uncatched Exception";
if(isset($_POST["action"])&&$_POST["action"]==="login"){
	if(PASSWORD === $_POST["password"]){//パスワード確認
		$_SESSION["TEST"] = md5(PASSWORD);//暗号化してセッションに保存
		$login = "success";
		$message = "ログイン成功";
	}else{
		session_destroy();
		$login = "failed";
		$message = "ログインパスワードが間違っています。";
	}
}
$profile = array(
    'message' => $message,
    'result' => $login,
);
header('Content-type: application/json');
echo json_encode($profile);
?>
