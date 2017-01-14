<?php
session_start();
if (!isset($_SESSION["admin"])) {
	header("Location: secure/login.php");
	exit;
}