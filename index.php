<?php

header('Content-Type: text/html; charset=utf-8');

/* ログイン認証済みかどうか */
$unauthorized = false;

$logout = false;

/* 現在時刻をチャレンジIDとして取得 */
$salt = time();

/* ログイン期間を5分間に設定 */
$expire = $salt + (60 * 5);

/* クッキーにチャレンジIDを期限付きで保存 */
setcookie("expire", $salt, $expire, "/");

/* 認証済みかどうかで特定の要素を入れ替える */
session_name("member");
session_start();
if (isset($_SESSION["user"]))
{
    
    /* 認証済みならセッションを再開 */
    $user = $_SESSION["user"];
    session_regenerate_id();

    require_once "php/member-main.php";
    
}
else
{
    
	$unauthorized = true;
	require_once "php/member-auth.php";
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Twitterでグループワーク</title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/start/jquery-ui.css" type="text/css" media="screen" />
</head>
<body>  
    <!-- 認証がまだなら認証画面を、済んでいればユーザー画面のHTMLをコンテナ要素に挿入する -->
    <div id="container"><?= $unauthorized === true ? $auth_html : $main_html ?></div>
    <!-- ダイアログ用の要素 -->
    <div id="dialog"> </div>
    <script src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        // <![CDATA[
        google.load('jquery', '1.5');
        google.load('jqueryui', '1.8');
        google.setOnLoadCallback(function () {
            /* 認証済みかどうかで初期化する関数を変更 */
                <?php 
                if($unauthorized === true){
                    echo "authorize();";
                }else{
                    echo "logout();\r\n";
                } 
                if($logout === true){
                    echo "pop();\r\n";
                }
                
                ?>      
        });
        </script>
    <script type="text/javascript" src="js/member.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/sha1.js"></script>

</body>
</html>


