<?php

function menu($arr, $direction="vert") {
  echo "<ul class='menu {$direction}'>";
  foreach ($arr as $item) {
  echo <<<HEREDOC
    <li><a href="{$item['link']}">{$item['name']}</a></li>
HEREDOC;
  }
  echo "</ul>";
}

function clear_str($data) {
  global $link;
  return mysqli_escape_string($link, trim(strip_tags($data)));
}

function clear_int($data) {
  return (int) abs($data);
}

function create_bd($bd_name) {
  global $link;
  $sql = "CREATE DATABASE ".$bd_name;
  return mysqli_query($link, $sql);
}

function create_table_arts() {
  global $link;
  $sql = "CREATE TABLE articles(
            id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(30) NOT NULL DEFAULT '',
            author VARCHAR(30) NOT NULL DEFAULT '',
            category INTEGER NOT NULL DEFAULT '',
            text TEXT,
            datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
  return mysqli_query($link, $sql);
}

function create_table_categ() {
  global $link;
  $sql = "CREATE TABLE categories(
            id INTEGER NOT NULL PRIMARY KET AUTO_INCREMENT,
            category VARCHAR(30) NOT NULL DEFAULT '')";
  return mysqli_query($link, $sql);
}

function res2arr($res) {
  $arr = [];
  while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    $arr[] = $row;
  return $arr;
}

function get_arts() {
  global $link;
  $sql = "SELECT id, title, author, category, text, datetime FROM articles ORDER BY id DESC";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  return res2arr($res);
}

function get_art($id) {
  global $link;
  $sql = "SELECT id, title, author, category, text, datetime FROM articles WHERE id=$id";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
  return $row;
}

function save_art($title, $author, $category, $text) {
  global $link;
  $sql = "INSERT INTO articles(title, author, category, text) VALUES(?, ?, ?, ?)";
  $stmt = mysqli_stmt_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "ssis", $title, $author, $category, $text);
  if (!mysqli_stmt_execute($stmt)) return false;
  mysqli_stmt_close($stmt);
  return true;
}

function update_art($id, $title, $author, $category, $text) {
  global $link;
  $sql = "UPDATE articles SET title=$title, author=$author, category=$category, text=$text WHERE id=$id";
  return mysqli_query($link, $sql);
}

function show_all_arts($arr) {
  echo "<article>";
  foreach ($arr as $item) {
    $date = date("r", $item["date"]);
    echo <<<HEREDOC
    <p><span>{$item['author']}</span> <em>{$item['date']}</em></p>
    <h4>{$item['title']}</h4>
    {$item['art']}
HEREDOC;
  }
  echo "</article>";
}

function show_art() {
  
}