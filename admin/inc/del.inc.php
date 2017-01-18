<?php
//Вывести весь список статей со ссылкой удаления
$arr = get_arts();
if (!$arr) {
  $msg = "Ошибка получения данных из бд";
} else {
	echo "<ul class='arts'>";
	foreach ($arr as $item) {
		echo "<li>{$item['title']} <a href=\"{$_SERVER['PHP_SELF']}?adm=3&del={$item['id']}\">Удалить</a></li>";
	}
	echo "</ul>";
	// show_arts_admin($arr, "<a href=\"{$_SERVER['REQUEST_URI']}&del={$item['id']}\">Удалить</a>");
}

//Удал-е статьи и пересохранение:
if (isset($_GET["del"])) {
  if (!delete_art($_GET["del"])) {
  	$msg= "Ошибка удаления из бд";
  } else {
	  header("Location: ".$_SERVER['PHP_SELF']."?adm=3");//убрать del=id
	  exit;
	}
}
