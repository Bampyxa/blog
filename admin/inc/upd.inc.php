<?php
$title = "";
$article = "";
//Редактируем полученную статью
if (isset($_GET["upd"])) {
  $arr = get(FILE_DB);
	$arr = upd($arr, $_GET["upd"]);
	list($title, $_, $article) = explode("|", $arr);
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
  $a = $_POST["article"];
  if (!$t and !$a) {//проверка на пуст. поля
    $msg = "Заполните поля";
  } else {
    $dt = time();
    $str = "$t|$dt|$a\n";
    $arr = get(FILE_DB);
    // for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {//!!!
    	//
	    save(FILE_DB, $str);
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