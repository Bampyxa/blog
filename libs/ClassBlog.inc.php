<?php

class Blog{
  private $_db;
  public $categs = ["HTML", "CSS", "JS", "PHP"];
  const DB_FILE = "/home/anton/www+/site2/files/arts.db";
  const XML_FILE = "/home/anton/www+/site2/files/map.xml";
  const COMM_FILE = "/home/anton/www+/site2/files/comments.txt";
  static public $count = 0;
  function __construct() {
    $this->_db = new SQLITE3(self::DB_FILE);
    if (filesize(self::DB_FILE)==0) {
      $sql = "CREATE TABLE IF NOT EXISTS articles (
             id integer PRIMARY KEY AUTOINCREMENT,
             title text,
             author text,
             category integer,
             text_art text,
             datetime integer)";
      if (!$this->_db->exec($sql))
        return false;
      $sql = "CREATE TABLE IF NOT EXISTS categories (
             id integer,
             category int)";
      if (!$this->_db->exec($sql))
        return false;
     $sql = "INSERT INTO categories (id, category) ";
     $i = 1;
     $cnt = count($this->categs);
     foreach ($this->categs as $item) {
       $sql .= " SELECT $i as id, '$item' as category ";
       if ($i<$cnt)
         $sql .= " UNION ";
       $i++;
     }
      if (!$this->_db->exec($sql))
        return false;
    }
    self::$count++;
  }
  function __destruct() {
    unset($this->_db);
  }
/***********Articles**************/
  function saveArt($title, $author, $category, $text_art) {
    $datetime = time();
    $sql = "INSERT INTO articles (title, author, category, text_art, datetime) VALUES (:t, :a, :c, :ta, :d)";
    $stmt = $this->_db->prepare($sql);
    $stmt->bindParam(':t', $title);
    $stmt->bindParam(':a', $author);
    $stmt->bindParam(':c', $category);
    $stmt->bindParam(':ta', $text_art);
    $stmt->bindParam(':d', $datetime);
    if (!$stmt->execute())
      return false;
    $stmt->close();
    $this->createXml(self::XML_FILE);
    return true;
  }
  function res2Arr($res) {
    $arr = [];
    while ($row = $res->fetchArray(SQLITE3_ASSOC))
      $arr[] = $row;
    return $arr;
  }
  function getArts() {
    $sql = "SELECT a.id, title, author, c.category, text_art, datetime FROM articles a INNER JOIN categories c ON a.category=c.id";
    if (!$res = $this->_db->query($sql))
      return false;
    return $this->res2Arr($res);
  }
  function getArtsCat($cat) {
    $sql = "SELECT a.id, title, author, c.category, text_art, datetime FROM articles a INNER JOIN categories c ON a.category=c.id WHERE a.category=$cat";
    if (!$res = $this->_db->query($sql))
      return false;
    return $this->res2Arr($res);
  }
  function getArt($id) {
    $sql = "SELECT a.id, title, author, c.category, text_art, datetime FROM articles a INNER JOIN categories c ON a.category=c.id WHERE a.id=$id";
    if (!$res = $this->_db->query($sql))
      return false;
    $row = $res->fetchArray(SQLITE3_ASSOC);
    return $row;
  }
  function getArtName($id) {
    $sql = "SELECT title FROM articles WHERE id=$id";
    if (!$res = $this->_db->query($sql))
      return false;
    $row = $res->fetchArray(SQLITE3_ASSOC);
    return $row["title"];//вернем строку
  }
  function getCategories() {
    $sql = "SELECT id, category FROM categories";
    if (!$res = $this->_db->query($sql))
      return false;
    return $this->res2Arr($res);
  }
  function getCategory($cat) {
    $sql = "SELECT id, category FROM categories WHERE id=$cat";
    if (!$res = $this->_db->query($sql))
      return false;
    $row = $res->fetchArray(SQLITE3_ASSOC);
    return $row;
  }
  function delArt($id) {
    $sql = "DELETE FROM articles WHERE id=$id";
    if (!$this->_db->exec($sql))
      return false;
    $this->createXml(self::XML_FILE);
    return true;
  }
  function updArt($id, $title, $author, $category, $text_art) {
    $sql = "UPDATE articles SET title='$title', author='$author', category=$category, text_art='$text_art' WHERE id=$id";
    if (!$this->_db->exec($sql))
      return false;
    $this->createXml(self::XML_FILE);
    return true;
  }
/***********Comments**************/
  //сохр. строку или одномер.масс.:
  function saveComm($str, $end_file=FILE_APPEND) {
    if (!file_put_contents(self::COMM_FILE, $str, $end_file))
      return false;
    return true;
  }
  //получ. масс. всех строк:
  function getAllComms() {
    if (!file_exists(self::COMM_FILE))
      return false;
    $res = file(self::COMM_FILE);
    return $res;//[]
  }
  //разбив. строку на пер-е(исп-ся в ф-и вывода на экран):
  function explodeStr($arr) {
    $resArr = [];
    foreach($arr as $item) {
      list($idArt, $dt, $nick, $coded) = explode("|", $item);
      $comment = base64_decode($coded);
      $resArr[] = [$idArt, $dt, $nick, $comment];
    }
    return $resArr;//[[]]
  }
  //удал. опред-й строки из масс. строк:
  function delComm($arr, $id) {
    unset($arr[$id]);
    return $arr;
  }
  function showCommsArt($arr, $idArt) {
    $arrArr = $this->explodeStr($arr);//получ. масс. массивов с нуж. пер-ми
    for($i=0 , $cnt=count($arrArr); $i<$cnt; $i++) {
      $item = $arrArr[$i];
      if ($item[0] == $idArt) {
        $dt = date("d-m-Y H:i:s", $item[1]);
        echo <<<HEREDOC
        <li><p><b> $item[2] </b><i> $dt </i></p>
        <p> $item[3] </p>
        <p><a href='{$_SERVER['PHP_SELF']}?id=$idArt&upd_com={$i}'>Редактировать</a></p> </li>
HEREDOC;
        }
      }
    }
    function showAllComms($arr) {
      $arrArr = $this->explodeStr($arr);//получ. масс. массивов с нуж. пер-ми
      for($i=0 , $cnt=count($arrArr); $i<$cnt; $i++) {
        $item = $arrArr[$i];
        $dt = date("d-m-Y H:i:s", $item[1]);
        $title = $this->getArtName($item[0]);//название статьи c опред. id
        echo <<<HEREDOC
        <li><p> $title <b> $item[2] </b><i> $dt </i></p>
        <p> $item[3] </p>
        <p><a href='{$_SERVER['PHP_SELF']}?adm=4&del_com={$i}'>Удалить</a></p> </li>
HEREDOC;
      }
    }
/*************XML******************/
  function createXml() {
    $dom = new DomDocument("1.0", "utf-8");
    $dom->formatOutput = true;
    $dom->preserveWhiteSpace = false;
    //
    $root = $dom->createElement("articles");
    $dom->appendChild($root);
    //
    $arr = $this->getArts();
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
    $dom->save(self::XML_FILE);
  }
  function readXml() {
    if (!file_exists(self::XML_FILE))
      return false;
    $sxml = simplexml_load_file(self::XML_FILE);
    echo "<ul>";
    foreach ($sxml->article as $item) {
      echo <<<HEREDOC
      <li>{$item->category} <a href="index.php?id={$item['id']}">{$item->title}</a></li>
HEREDOC;
    }
    echo "</ul>";
  }
/***********Other**************/
  function clearStr($data) {
    return $this->_db->escapeString(trim(strip_tags($data, "<p><a><b><i><img><table><tr><th><td><div>")));
  }
  function clearInt($data) {
    return abs((int)$data);
  }
  function showArts($arr) {
    foreach($arr as $item) {
      $dt = date("d-m-Y H:i:s", $item["datetime"]);
      echo <<<HEREDOC
      <article>
      <p><span>{$item["author"]}</span>
      <b>{$item["category"]}</b>
      <i>{$dt}</i></p>
      <h4><a href="index.php?id={$item['id']}">{$item['title']}</a></h4>
      {$item["text_art"]}
      </article>
HEREDOC;
    }
  }
  function showArt($arr) {
    $dt = date("d-m-Y H:i:s", $arr["datetime"]);
      echo <<<HEREDOC
      <article>
      <p><span>{$arr["author"]}</span>
      <b>{$arr["category"]}</b>
      <i>{$dt}</i></p>
      <h4>{$arr["title"]}</h4>
      {$arr["text_art"]}
      </article>
HEREDOC;
  }
  function menu($arr, $direction="vert") {
    echo "<ul class='menu {$direction}'>";
    foreach ($arr as $item) {
    echo <<<HEREDOC
      <li><a href="{$item['link']}">{$item['name']}</a></li>
HEREDOC;
    }
    echo "</ul>";
  }
  /*function logOut() {
    session_destroy();
    header("Location: ".dirname($_SERVER['PHP_SELF'])."/secure/login.php");
    exit;
  }*/
}
