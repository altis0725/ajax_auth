<?php

header('Content-Type: text/html; charset=utf-8');

$param = $_GET["param"];

/* 現在時刻をチャレンジIDとして取得 */
$salt = time();

/* ログイン期間を5分間に設定 */
$expire = $salt + (60 * 5);

/* クッキーにチャレンジIDを期限付きで保存 */
setcookie("expire", $salt, $expire, "/");

/* 認証ページのHTMLを読み込む */
require_once "member-auth.php";

/* ログアウト送信が行われたときの処理 */
if (isSet($param) && $param == "logout")
{
	session_name("member");
	session_start();
	if (isSet($_COOKIE[session_name()]))
	{
		setcookie(session_name(), "", time() - (60 * 60 * 24), "/");
	}
	session_destroy();

	echo $auth_html;
}

?>