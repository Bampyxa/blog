<?php

/*const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "12qw-=";
const DB_NAME = "blog";
const XML_FILE = "/home/anton/www+/site2/files/arts.xml";//абсол-й путь(для сайта и админки)*/
// $categs = ["HTML", "CSS", "JS", "PHP"];

//init bd
/*$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if (!mysqli_select_db($link, DB_NAME)) {//если базы не сущест.
  create_db(DB_NAME);
  mysqli_select_db($link, DB_NAME);//выбираем ее для последующ. созд-я табл.
  create_table_arts();
  create_table_categ();
  add_categories($categs);
}*/

//for main menu:
$links = [
	["link"=>"index.php", "name"=>"Главная страница"],
	["link"=>"index.php?page=feedback", "name"=>"Обратная связь"],
	["link"=>"index.php?page=map", "name"=>"Карта сайта"]
];
//for menu categories:
$categs = $blog->categs;
$link_cats = [];
for ($i=0, $j=1, $cnt=count($categs); $i<$cnt; $i++, $j++) {
  $arr = [];
  $arr["link"] = "index.php?cat=$j";
  $arr["name"] = "$categs[$i]";
  $link_cats[] = $arr;
}
$msg = "";