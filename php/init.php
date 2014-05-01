<?php
session_name("member");
session_start();
session_regenerate_id();
$user = $_SESSION["user"];
$user = htmlSpecialChars($user);
require_once "auth-init.php";

$data = $db->query("SELECT * FROM user_auth WHERE username = '$user'");
if (!empty($user))
{
	while ($row = $data->fetch(PDO::FETCH_ASSOC))
	{
        $pass = $row["password"];
	}
}
else
{
	die("failed");
}

?>
