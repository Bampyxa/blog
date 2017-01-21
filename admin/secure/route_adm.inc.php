<?php
//default:
$title_site = "Админка";
$header = "Доступные действия";
//по-умолч. не инклюд-ся, а толь. если есть GET-пер-я:

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

/*if (isset($_GET["logout"])) {//переместил в session.inc.php
	$blog->logOut();
}*/
