<?php

if (isset($_GET["page"])) {
	switch ($_GET["page"]) {
	  case "feedback" :
	    $include = "inc/feedback.inc.php";
	    $title = "Обратная связь";
	    $header = "Послать письмо";
	    break;
	  case "map" :
	    $include = "inc/map.inc.php";
	    $title = "Карта сайта";
	    $header = "Просмотреть карту сайта";
	    break;
	}
}

else if (isset($_GET["id"])) {
	$art = get_art($_GET["id"]);
	if (!$art) $msg = "Не получены данные из бд";
	$include = "inc/art.inc.php";
	$title = $art["category"]." | ".$art["title"];
	$header = $art["title"];
}

else if (isset($_GET["cat"])) {
	$cat = get_category($_GET["cat"]);
	$include = "inc/arts_cat.inc.php";
	$title = $cat["category"];
	$header = $cat["category"];

} else {
	$include = "inc/arts.inc.php";
	$title = "Тест-сайт";
	$header = "Новое на сайте";
}