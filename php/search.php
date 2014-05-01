<?php
require_once("twitteroauth/twitteroauth.php");

$hash = $_POST['hash'];

$consumer_key = "9fx7ZGFVoNUAN7fgrQ9UbA";
$consumer_secret = "rrNJ97Kz2vTPgha4C3jwcsxqHt0dP5ekpvxn1oVnw";
$access_token = "977801095-p6dFwY5Pl69I0nloHvcLa4AZ1GLET0xF5GaYzF4N";
$access_token_secret = "4bnGBNTJNiO9VRqF0OTz25aLxW9sdndOHeRbjUILMY";

// OAuthオブジェクト生成
$twitter = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

$response = $twitter->get( "search/tweets", array("q" => "#".$hash, "result_type" => "recent", "count" => "1500", "include_entities" => "true") );
$http_info = $twitter->http_info;

if ($http_info["http_code"] == "200" && empty( $response->statuses ) ) {
    //print_r($response);
    echo "OK";
}else{
    /*
    print_r($response);
    $rows = $response->statuses;
    foreach($rows as $row){    
        echo $row->user->name;
        echo PHP_EOL;
    }*/
    echo "error";
}


?>
