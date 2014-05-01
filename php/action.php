<?php  
header('Content-Type: text/html; charset=utf-8');
require_once("twitteroauth/twitteroauth.php");

$status = $_POST['status'];
$item = $_POST['item'];
$geo = $_POST['geo'];
$hash = $_POST['hash'];
$hash = mb_convert_kana(trim($hash),"rnKHV","utf-8");

$consumer_key = "qnnhUFIVVxPzqkwjBByVQ";
$consumer_secret = "zExEaRwlZDjJlqpC38f52h6uBgt9BRbUrQGmkLOw58";
$access_token = "229542951-lMSY7yWWYR0Cif2ifAESNeQjJjM5XYHvKM6rxzZk";
$access_token_secret = "BObSxmqPmgiNAuJv6EtBrkz2ODajQpUEssP7cyPhqCM";

// OAuthオブジェクト生成
$twitter = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

$tw = "ハッシュタグ名は #$hash";
for($i=0;$i<count($status);$i++){
    $j = $i + 1;
    $tw .= "、ステータス $j は 『$status[$i]』で 『$item[$i]』型";
}
if($geo === "geo_on"){
    $tw .= "で、位置情報をgeoタグで付加してください。"; 
}else if($geo === "geo_place"){
    $tw .= "で、位置情報をplaceタグで付加してください。";
}else if($geo === "geo_tweet"){
    $tw .= "で、位置情報を本文に付加してください。";
}else{
    $tw .= "で、位置情報はなしです。";
}

$response = $twitter->post( "statuses/update", array("status" => $tw) );
$http_info = $twitter->http_info;

if ($http_info["http_code"] == "200" && !empty( $response ) ) {
    require_once "init.php";
    //connect to mysql server, server name: main, database username: root
    $link_ID = mysql_connect("localhost",$user,$pass) or
        die("Could not connect: " . mysql_error());
    mysql_select_db($user); //abc is the database name
    mysql_set_charset('utf8');
    $str = "CREATE TABLE `$hash`(twTime DATETIME, twID CHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci";

    for($i=0;$i<count($status);$i++){
        if($item[$i] === "text"){
            $value = "CHAR(200)";
            $str .= ",`$status[$i]` $value CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'text'";
        }else if($item[$i] === "image"){
            $value = "CHAR(255)";
            $str .= ",`$status[$i]` $value CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'image'";
        }
        
    }
    if($geo !== "geo_off"){
        $str .= ", geo CHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci";
    }
    
    if($geo === "geo_on"){
        $str .= " COMMENT 'geo'";
    }else if($geo === "geo_place"){
        $str .= " COMMENT 'place'";
    }else if($geo === "geo_tweet"){
        $str .= " COMMENT 'tweet'";
    }
    
    
    $str .= ')';
    
    if($geo === "geo_on"){
        $str .= " COMMENT = 'geo'";
    }else if($geo === "geo_place"){
        $str .= " COMMENT = 'place'";
    }else if($geo === "geo_tweet"){
        $str .= " COMMENT = 'tweet'";
    }
    
    $str .= ";";
    
    //echo $str;
    $result = mysql_query($str,$link_ID);
    mysql_close($link_ID);
    echo $str;
    echo PHP_EOL;
    echo $tw;
}
?>