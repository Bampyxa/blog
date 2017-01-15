<?php
$title = "";
$article = "";
//Редактируем полученную статью
if (isset($_GET["upd"])) {
  $id = $_GET["upd"];
  $arr = get(FILE_DB);
	$row = get_item_for_upd($arr, $id);
	list($title, $_, $article) = explode("|", $row);
	$article = base64_decode($article);
}
?>

<fieldset>
<legend>Редактировать статью</legend>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
    <input type="text" name="title" value="<?=$title?>"><br>
    <textarea name="article"><?=$article?></textarea><br>
    <input type="submit">
  </form>
</fieldset>

<?php
//Пересохранение статьи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $t = $_POST["title"];
  $a = base64_encode($_POST["article"]);
  $id = $_GET["upd"];
  if (!$t and !$a) {//проверка на пуст. поля
    $msg = "Заполните поля";
  } else {
    $dt = time();
    $str = "$t|$dt|$a\n";
    $arr = get(FILE_DB);
    // for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {//!!!
    	//
     $arr = upd($arr, $id, $str);
	    save(FILE_DB, $arr, NULL);
     //header("Location: ".$_SERVER['REQUEST_URI']."/index.php");
     header("Location: index.php?adm=2");
     exit;
	  // }
  }
}

//Вывод всех статей со ссылкой редактирования
$action = "upd";
$act_name = "Редактировать";
if (!file_exists(FILE_DB)) {
  $msg = "Такого файла нет";
} else {
  $arr = get(FILE_DB);
	show($arr, $action, $act_name);
}