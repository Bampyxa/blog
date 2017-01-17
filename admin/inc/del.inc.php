<?php
//Вывести весь список статей со ссылкой удаления
$page = 3;
$action = "del";
$act_name = "Удалить";
if (!file_exists(FILE_DB)) {
  $msg = "Такого файла нет";
} else {
  $arr = get(FILE_DB);
	show($arr, $page, $action, $act_name);
}

//Удал-е статьи и пересохранение:
if (isset($_GET["del"])) {
  $arr = get(FILE_DB);//
  $arr = del($arr, $_GET["del"]);
  save(FILE_DB, XML_FILE, $arr, NULL);
  header("Location: index.php?adm=3");//убрать del=id
  exit;
}
