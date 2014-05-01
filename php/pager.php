<?php

header('Content-Type: text/html; charset=utf-8');

$page = $_GET["page"];
$page = htmlSpecialChars($page);
//mb_convert_variables("SJIS", "UTF-8", $page);

$result = "failed";

switch($page) {
	case "register":
		require_once "member-regi.php";
		$result = $regi_html;
		echo $result;
		break;
}

function isAuth($name) {
	$authorized = false;

	session_name($name);
	session_start();
	if (isset($_SESSION["user"]))
	{
		$authorized = true;
	}

	return $authorized;
}

?>