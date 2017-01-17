<?php
const FILE_DB = "files/arts.txt";
const XML_FILE = "files/arts.xml";

$links = [
	["link"=>"index.php", "name"=>"Главная страница"],
	["link"=>"index.php?page=feedback", "name"=>"Обратная связь"],
	["link"=>"index.php?page=map", "name"=>"Карта сайта"]
];

$include = "inc/arts.inc.php";
$title = "Тест-сайт";
$header = "Новое на сайте";
if (isset($_GET["page"])) {
	switch ($_GET["page"]) {
	  case "feedback" :
	    $include = "inc/feedback.inc.php";
	    $title .= " | Обратная связь";
	    $header = "Послать письмо";
	    break;
	  case "map" :
	    $include = "inc/map.inc.php";
	    $title .= " | Карта сайта";
	    $header = "Просмотреть карту сайта";
	    break;
	}
}