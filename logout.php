<?php
include_once 'core/init.php';

$user = new User();
$user->logout();
session_destroy();
if (!isset($_SESSION))
{
	session_start();
	$_SESSION["user_name"] = "guest";
}
Redirect::to('index.php');
?>