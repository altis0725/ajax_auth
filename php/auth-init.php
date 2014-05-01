<?php

//require_once "DB.php";

$dsn = array(
	'phptype'  => 'mysql',
	'dbsyntax' => false,
	'username' => 'account',
	'password' => 'XuV98dFHXD7CWzsE',
	'protocol' => false,
	'hostspec' => 'localhost',
	'port'     => false,
	'socket'   => false,
	'database' => 'account'
);


try {
    $db = new PDO("${dsn['phptype']}:host=${dsn['hostspec']};dbname=${dsn['database']}",$dsn['username'], $dsn['password'],
        array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"
        )
    );
} catch (PDOException $db) {
    die($db->getMessage());
}

$db->query("SET NAMES utf8");

?>