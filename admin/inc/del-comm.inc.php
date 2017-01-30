<?php

$arr = $blog->getAllComms();
if (!$arr) {
  $msg = "Не могу показать комменты";
} elseif (isset($_GET["del_com"])) {
	$newArr = $blog->delComm($arr, $_GET["del_com"]);
	// var_dump($newArr);
	$blog->saveComm($newArr, null);
	header("Location: ".$_SERVER["PHP_SELF"]."?adm=4");
	exit;
} else {
	$blog->showAllComms($arr);
}