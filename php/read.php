<?php
//header('Content-Type: text/html; charset=utf-8');
require_once "init.php";

//connect to mysql server, server name: main, database username: root

$link_ID = mysql_connect("localhost",$user,$pass) or
    die("Could not connect: " . mysql_error());
mysql_select_db($user); //abc is the database name
mysql_set_charset('utf8');
$str="show tables;" ;
$result = mysql_query($str, $link_ID);
$rows =  mysql_num_rows($result);

if($rows){
    while ($row = mysql_fetch_array($result)) {
        $massage[] = $row[0];
    }
}
/*
for ($i=1;$i<=$l; $i++) {
    list($chtime, $nick, $words, $filepath)=mysql_fetch_row($result);
    //$massage .= "<div>".nl2br(htmlentities($chtime." ".$nick.":".$words,ENT_QUOTES,"UTF-8"))."</div>";
    $massage[] = array(
        "chtime"=>$chtime,
        "nick"=>$nick,
        "words"=>$words,
        "filepath"=>$filepath
    );
} */

mysql_close($link_ID);

$jsontext = json_encode($massage);
print_r ($jsontext);

?>
