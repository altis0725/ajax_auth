<?php
$name = $_POST["name"];
$server = $_POST["server"];

try {
    $ac = new PDO("mysql:host=localhost;dbname={$server}","altis0725", "keio8000",
        array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"    
            )
        );
} catch (PDOException $e) {
    die($e->getMessage());
}
$ac->query("SET NAMES utf8");

$rows = $ac->query("SELECT * FROM {$name} ORDER BY twTime");

$data = Array();
while($row = $rows->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row;
}

$jsontext = json_encode($data);
echo $jsontext;



?>