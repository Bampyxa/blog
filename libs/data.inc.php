<?php

const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "12qw-=";
const DB_NAME = "blog";
const XML_FILE = "/home/anton/www+/site2/files/arts.xml";//абсол-й путь(для сайта и админки)
$categs = ["HTML", "CSS", "JS", "PHP"];

//init bd
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if (!mysqli_select_db($link, DB_NAME)) {//если базы не сущест.
  create_db(DB_NAME);
  mysqli_select_db($link, DB_NAME);//выбираем ее для последующ. созд-я табл.
  create_table_arts();
  create_table_categ();
  add_categories($categs);
}

//for menu
$links = [
	["link"=>"index.php", "name"=>"Главная страница"],
	["link"=>"index.php?page=feedback", "name"=>"Обратная связь"],
	["link"=>"index.php?page=map", "name"=>"Карта сайта"]
];
$link_cats = [
	["link"=>"index.php?cat=1", "name"=>"HTML"],
	["link"=>"index.php?cat=2", "name"=>"CSS"],
	["link"=>"index.php?cat=3", "name"=>"JS"],
	["link"=>"index.php?cat=4", "name"=>"PHP"]
];
$msg = "";