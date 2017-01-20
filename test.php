<?php
class Blog{
  private $_db;
  private $categs = ["HTML", "CSS", "JS", "PHP"];
  const DB_FILE = "files/blog.db";
  function __construct() {
    //if ($this->_db->open(DB_FILE))
    $this->_db = new SQLITE3(DB_FILE);
    if (!$this->_db)
      return false;
    $sql = "CREATE TABLE articles (
           id integer,
           title text,
           author text,
           category integer,
           text_art text,
           datetime integer)";
    if (!$this->_db->exec($sql))
      return false;
    $sql = "CREATE TABLE categories (
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
  function __destruct() {
    $this->_db->close();
  }
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
    return true;
  }
  function res2Arr($res) {
    $arr = [];
    while ($row = $this->_db->fetchArray($res, SQLITE3_ASSOC))
      $arr[] = $row;
  }
  function getArts() {
    $sql = "SELECT a.id, title, author, c.category, text_art, datetime FROM articles a INNER JOIN categories c TO a.category=c.id";
    if (!$this->_db->query($sql))
      return false;
    return res2Arr($res);
  }
  function getArt($id) {
    $sql = "SELECT a.id, title, author, c.category, text_art, datetime FROM articles a INNER JOIN categories c TO a.category=c.id WHERE a.id=$id";
    if (!$this->_db->query($sql))
      return false;
    return res2Arr($res);
  }
  function getArtsCat($cat) {
    $sql = "SELECT a.id, title, author, c.category, text_art, datetime FROM articles a INNER JOIN categories c TO a.category=c.id WHERE a.categories=$cat";
    if (!$this->_db->query($sql))
      return false;
    return res2Arr($res);
  }
  function delArt($id) {
    $sql = "DELETE FROM articles WHERE id=$id";
    return $this->_db->exec($sql);
  }
  function updArt($id, $title, $author, $category, $text_art) {
    $sql = "UPDATE SET title='$title', author='$author', category=$category, text_art='$text_art' WHERE id=$id";
    return $this->_db->exec($sql);
  }
  function clearStr($data) {
    return $this->_db->escapeString(trim(strip_tags($data)));
  }
  function clearInt($data) {
    return abs((int)$data);
  }
  function showArts($arr) {
    foreach($arr as $item) {
      echo <<<HEREDOC
      <article>
      <p><span>{$item["author"]}</span>
      <b>{$item["category"]}</b>
      <i>{$item["datetime"]}</i></p>
      <h4>{$item["title"]}</h4>
      {$item["text_art"]}
      </article>
HEREDOC;
    }
  }
}