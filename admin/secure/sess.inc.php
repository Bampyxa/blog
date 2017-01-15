<?php
session_start();
if (!isset($_SESSION["admin"])) {
	//header("Location: /admin/secure/login.php");//-admin
 header("Location: ".dirname($_SERVER['PHP_SELF'])."/secure/login.php");
	exit;
}