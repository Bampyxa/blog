<?php
// require_once 'lib.inc.php';//???

//Сохранение добавленной статьи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $t = $_POST["title"];
  $a = $_POST["article"];
  if (!$t and !$a) {//проверка на пуст. поля
    $msg = "Заполните поля";
  } else {
    $dt = time();
    $a = base64_encode($a);
    $str = "$t|$dt|$a\n";
    if (!save(FILE_DB, $str))
    	$msg = "Данные не записались";
  }
}
?>

<fieldset>
<legend>Добавить статью</legend>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
    <input type="text" name="title"><br>
    <textarea name="article"></textarea><br>
    <input type="submit">
  </form>
</fieldset>

<?php
//Вывод всех статей
if (!file_exists(FILE_DB)) {
  $msg = "Такого файла нет";
} else {
  $arr = get(FILE_DB);
	show($arr, $action="", $act_name="");//???добав-ся ненуж. ссылка
}
