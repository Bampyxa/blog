<?php
/*const DB_HOST = "http://site2";
const DB_USER = "root";
const DB_PASS = "12qw-=";
const DB_NAME = "blog";
const XML_FILE = "/files/arts.xml";

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if (!mysqli_select_db($link, DB_NAME)) {//если базы не сущест.
	create_db(DB_NAME);
	mysqli_select_db($link, DB_NAME);//выбираем ее для последующ. созд-я табл.
	create_table_arts();
	create_table_categ();
}*/

$include = "";
$title_site = "Админка";
$header = "Доступные действия";

if (isset($_GET["adm"])) {
	switch ($_GET["adm"]) {
	  case "1" :
	    $include = "inc/save.inc.php";
	    $title_site .= " | Создание статей";
	    $header = "Создать статью";
	    break;
	  case "2" :
	    $include = "inc/upd.inc.php";
	    $title_site .= " | Редактирование статей";
	    $header = "Редактировать статью";
	    break;
	  case "3" :
	    $include = "inc/del.inc.php";
	    $title_site .= " | Удаление статей";
	    $header = "Удалить статью";
	    break;
	}
}

if (isset($_GET["logout"])) {
	logout();
}