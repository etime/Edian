<?php

require_once 'dsprint.class.php';

//utf-8格式
header("Content-Type:text/html;charset=UTF-8");

$app=$_REQUEST['appid'];
$pass=$_REQUEST['pass'];
$dtu=$_REQUEST['dtuid'];
$text=$_REQUEST['msgdetail'];
//var_dump($app,$pass,$dtu,$text);
$client = new DsPrintSend($pass,$app);
//打印字符串
echo "printer status: ".$client->printtxt($dtu,$text);

?>
