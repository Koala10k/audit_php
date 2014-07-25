<?php
// require_once ('FirePHPCore/FirePHP.class.php');
// ob_start();
// $firephp = FirePHP::getInstance(true);
// $firephp -> log('starting ');
// $mysqli = new mysqli("127.0.0.1", "pengd", "207071", "pengd");
$mysqli = new mysqli("127.0.0.1", "root", "", "pengd");
$db_conn_msg;
if ($mysqli -> connect_error) {
	$db_conn_msg = $mysqli -> connect_error;
	die('Connect Error (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error);
}
// echo phpinfo();
?>