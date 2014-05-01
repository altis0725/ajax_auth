<?php

/* HTML出力フォーマット */
header('Content-Type: text/html; charset=utf-8');

/* サーバー */
$request_url = getenv('REQUEST_URI');
$req = explode("?", $request_url);
$r = str_replace("php/auth.php", "",$req[0]);
//$r = str_replace("/", "", $r);

$server = "http://".getenv('HTTP_HOST').$r;

/* データベース接続 */
require_once "auth-init.php";

$user = $_GET["username"];
$pass = $_GET["password"];
$salt = $_GET["salt"];
$user = htmlSpecialChars($user);

/* メインページのHTML断片 */
require_once "member-main.php";

/* データベースのエンコードに変換 */
//mb_convert_variables("SJIS", "UTF-8", $user);
//mb_convert_variables("SJIS", "UTF-8", $pass);
//mb_convert_variables("SJIS", "UTF-8", $salt);

/* 結果を入れる変数 */
$result = "failed";

/* ログイン画面(index.php)からのみアクセス可に */
if ($referer = $_SERVER["HTTP_REFERER"])
{
	if ($referer != $server && $referer != $server."index.php")
	{
		die("不正なアクセスです。");
	}
}
else
{
	die("リファラーが取得できませんでした。");
}

/* クッキーが期限切れかどうかチェック */
if (!isset($_COOKIE["expire"]))
{
	die("expired");
}

/* パスワード照合 */
$data = $db->query("SELECT username, password FROM user_auth");
if (!empty($user))
{
	while ($row = $data->fetch(PDO::FETCH_ASSOC))
	{
		$sha1 = sha1($salt . $row["password"]);
		if ($row["username"] === $user && $sha1 === $pass)
		{
			$result = "successful";
			break;
		}
	}
}
else
{
	die($result);
}

/* 認証が成功したらユーザー画面のHTMLを返す */
if ($result === "successful")
{
	session_name("member");
	session_start();
	session_regenerate_id();

	$_SESSION = array();
    mb_language("Japanese");
	$_SESSION["user"] = mb_convert_encoding($user, "UTF-8", "auto");
    //$_SESSION["user"] = $user;
    

	setCookie("expire", "", time() - (60 * 60 * 24), "/");

	echo $main_html;
}
else
{
	die($result);
}



?>