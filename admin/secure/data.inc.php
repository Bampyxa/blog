<?php
$include = "";
$title = "Админка";
$header = "Доступные действия";
if (isset($_GET["adm"])) {
	switch ($_GET["adm"]) {
	  case "1" :
	    $include = "inc/save.inc.php";
	    $title .= " | Создание статей";
	    $header = "Создать статью";
	    break;
	  case "2" :
	    $include = "inc/upd.inc.php";
	    $title .= " | Редактирование статей";
	    $header = "Редактировать статью";
	    break;
	  case "3" :
	    $include = "inc/del.inc.php";
	    $title .= " | Удаление статей";
	    $header = "Удалить статью";
	    break;
	}
}