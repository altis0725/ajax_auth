<?php

header('Content-Type: text/html; charset=utf-8');

//saltの長さ
$saltLength = 32; 
$iterationCount = 1;

/* サーバー */
$request_url = getenv('REQUEST_URI');
$req = explode("?", $request_url);
$r = str_replace("php/regi.php", "",$req[0]);
//$r = str_replace("/", "", $r);

$server = "http://".getenv('HTTP_HOST').$r;


require_once "auth-init.php";

$user = $_GET["username"];
$pass = $_GET["password"];
$user = htmlSpecialChars($user);
require_once "member-main.php";

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

//$user = mb_convert_encoding($user, "UTF-8");
//mb_convert_variables("SJIS", "UTF-8", $pass);

/* ユーザー名の重複確認 */
$duplicated = false;
$data = $db->query("SELECT username FROM user_auth");
if (!empty($user))
{
	while ($row = $data->fetch(PDO::FETCH_ASSOC))
	{
		if ($row["username"] === $user)
		{
			$duplicated = true;
			break;
		}
	}
}
else
{
	die($result);
}

/* 認証が成功したらユーザー画面のHTMLを返す */
if (!$duplicated)
{
    try{
        $sql = "INSERT INTO user_auth (username, password) VALUES (?, ?)";
        $sth = $db->prepare($sql);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    
    try {
        $res = $sth->execute(array(${user}, ${pass}));
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    
    try {
    $account = new PDO("${dsn['phptype']}:host=${dsn['hostspec']};dbname=","ac_create", "zuqC4wfvLtqdLyYq",
        array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"
            )
        );
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $str=array(
        "SET NAMES utf8;",
        "CREATE USER '{$user}'@'localhost' IDENTIFIED BY '{$pass}';",
        "CREATE USER '{$user}'@'%' IDENTIFIED BY '{$pass}';",
        "CREATE DATABASE IF NOT EXISTS `{$user}` ;",
        "GRANT SELECT , INSERT , UPDATE , DELETE , CREATE , DROP ON `{$user}` . * TO '{$user}'@'localhost';",
        "GRANT SELECT , INSERT , UPDATE , DELETE , CREATE , DROP ON `{$user}` . * TO '{$user}'@'%';");

    for($i=0;$i<count($str);$i++){

        $a = $account->exec($str[$i]);
        $error = $account->errorInfo();
        if($a==null && $error[1]!=null){
            print_r($error);
        }
    }
    $account = null;

    
    
	session_name("member");
	session_start();
	session_regenerate_id();

	$_SESSION = array();
    //mb_language("Japanese");
	$_SESSION["user"] = mb_convert_encoding($user, "UTF-8", "auto");
    //$_SESSION["user"] = $user;

	setCookie("expire", "", time() - (60 * 60 * 24), "/");

	echo $main_html;
}
else
{
	$result = "duplicated";
	die($result);
}

?>