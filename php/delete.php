<?php
header('Content-Type: text/html; charset=utf-8');
$table = $_POST['table'];
require_once "init.php";
//connect to mysql server, server name: main, database username: root
$link_ID = mysql_connect("localhost",$user,$pass) or
    die("Could not connect: " . mysql_error());
mysql_select_db($user); //abc is the database name
mysql_set_charset('utf8');
$str="DROP TABLE `$table`;" ;
$result = mysql_query($str, $link_ID);

mysql_close($link_ID);

$jsontext = json_encode($result);
echo $jsontext;

?>
