<?php

function create_db($db_name) {
  global $link;
  $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
  return mysqli_query($link, $sql);
}

function create_table_arts() {
  global $link;
  $sql = "CREATE TABLE IF NOT EXISTS articles (
            id int NOT NULL AUTO_INCREMENT,
            title varchar(30) NOT NULL default '',
            author varchar(30) NOT NULL default '',
            category int NOT NULL default 1,
            text_art text,
            datetime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
            PRIMARY KEY (id))";
  return mysqli_query($link, $sql);
}

function create_table_categ() {
  global $link;
  $sql = "CREATE TABLE IF NOT EXISTS categories (
            id int NOT NULL AUTO_INCREMENT,
            category varchar(30) NOT NULL default '',
            PRIMARY KEY (id))";
  return mysqli_query($link, $sql);
}

function add_categories($arr) {
  global $link;
  $sql = "INSERT INTO categories (id, category) ";
  $i = 1;
  $cnt = count($arr);
  foreach ($arr as $item) {
    $sql .= " SELECT $i as id, '$item' as category ";
    if ($i<$cnt)
      $sql .= " UNION ";
    $i++;
  }
  return mysqli_query($link, $sql);
}

function save_art($title, $author, $category, $text) {
  global $link;
  $sql = "INSERT INTO articles(title, author, category, text_art) 
            VALUES(?, ?, ?, ?)";
  $stmt = mysqli_prepare($link, $sql);
  var_dump($stmt);
  mysqli_stmt_bind_param($stmt, "ssis", $title, $author, $category, $text);
  if (!mysqli_stmt_execute($stmt)) return false;
  mysqli_stmt_close($stmt);
  create_xml(XML_FILE);
  return true;
}

function res2arr($res) {
  $arr = [];
  while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    $arr[] = $row;
  return $arr;
}

function get_categories() {
  global $link;
  $sql = "SELECT id, category FROM categories";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
  return $row;
}

function get_category($cat) {
  global $link;
  $sql = "SELECT category FROM categories WHERE id=$cat";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
  return $row;
}

function get_arts() {
  global $link;
  $sql = "SELECT a.id, title, author, c.category, text_art, datetime 
           FROM articles a 
           INNER JOIN categories c ON a.category = c.id 
           ORDER BY id DESC";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  return res2arr($res);
}

function get_arts_cat($cat) {
  global $link;
  $sql = "SELECT a.id, title, author, c.category, text_art, datetime 
           FROM articles a 
           INNER JOIN categories c ON a.category = c.id 
           WHERE a.category=$cat 
           ORDER BY id DESC";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  return res2arr($res);
}

function get_art($id) {
  global $link;
  $sql = "SELECT a.id, title, author, c.category, text_art, datetime 
            FROM articles a, categories c 
            WHERE a.category=c.id AND a.id=$id";
  $res = mysqli_query($link, $sql);
  if (!$res) return false;
  $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
  return $row;
}

function create_xml($xml) {
  $dom = new DomDocument("1.0", "utf-8");
  $dom->formatOutput = true;
  $dom->preserveWhiteSpace = false;
  //
  $root = $dom->createElement("articles");
  $dom->appendChild($root);
  //
  $arr = get_arts();
  if (!$arr) return false;
  foreach ($arr as $item) {
    $article = $dom->createElement("article");
    $_id = $dom->createAttribute("id");
    $_id->value = "{$item['id']}";
    $article->appendChild($_id);
    //
    $_author = $dom->createElement("author", "{$item['author']}");
    $_category = $dom->createElement("category", "{$item['category']}");
    $_date = $dom->createElement("date", "{$item['datetime']}");
    $_title = $dom->createElement("title", "{$item['title']}");
    $_text = $dom->createElement("text");
    $cdata = $dom->createCDATASection("{$item['text_art']}");
    $_text->appendChild($cdata);
    //
    $article->appendChild($_author);
    $article->appendChild($_category);
    $article->appendChild($_date);
    $article->appendChild($_title);
    $article->appendChild($_text);
    //
    $root->appendChild($article);
  }
  $dom->save($xml);
}

function delete_art($id) {
  global $link;
  $sql = "DELETE FROM articles 
            WHERE id=$id";
  if (!mysqli_query($link, $sql))
    return false;
  create_xml(XML_FILE);
  return true;
}

function update_art($id, $title, $author, $category, $text) {
  global $link;
  $sql = "UPDATE articles 
            SET title='$title', author='$author', category=$category, text_art='$text' 
            WHERE id=$id";
  if (!mysqli_query($link, $sql))
    return false;
  create_xml(XML_FILE);
  return true;
}

function show_all_arts($arr) {
  foreach ($arr as $item) {
    echo <<<HEREDOC
    <article>
    <p><span>{$item['author']}</span> <b>{$item['category']}</b> <em>{$item['datetime']}</em></p>
    <h4><a href="index.php?id={$item['id']}">{$item['title']}</a></h4>
    {$item['text_art']}
    </article>
HEREDOC;
  }
}

function show_art($arr) {
  echo <<<HEREDOC
    <article>
    <p><span>{$arr['author']}</span> <b>{$arr['category']}</b> <em>{$arr['datetime']}</em></p>
    <h4>{$arr['title']}</h4>
    {$arr['text_art']}
    </article>
HEREDOC;
}

/*function show_arts_admin($arr, $param="") {
  echo "<ul class='arts'>";
  foreach ($arr as $item) {
    echo <<<HEREDOC
    <li>{$item['title']} {$param}</li>
HEREDOC;
  }
  echo "</ul>";
}*/

function read_xml($file) {
  $sxml = simplexml_load_file($file);
  echo "<ul>";
  foreach ($sxml->article as $item) {
    echo <<<HEREDOC
    <li>{$item->category} <a href="index.php?id={$item['id']}">{$item->title}</a></li>
HEREDOC;
  }
  echo "</ul>";
}

function clear_str($data) {
  global $link;
  return mysqli_escape_string($link, trim($data));//strip_tags для больш. текста не надо
}

function clear_int($data) {
  return (int) abs($data);
}

function menu($arr, $direction="vert") {
  echo "<ul class='menu {$direction}'>";
  foreach ($arr as $item) {
  echo <<<HEREDOC
    <li><a href="{$item['link_page']}">{$item['name']}</a></li>
HEREDOC;
  }
  echo "</ul>";
}

function logout() {
  session_destroy();
  header("Location: ".dirname($_SERVER['PHP_SELF'])."/secure/login.php");//-admin
  exit;
}