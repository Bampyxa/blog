<?php

//Сохранение добавленной статьи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $categ = $blog->clearStr($_POST["category"]);
  $author = $blog->clearStr($_POST["author"]);
  $title = $blog->clearStr($_POST["title"]);
  $text = $blog->clearStr($_POST["text_art"]);
  if (empty($author) and empty($title) and empty($text)) {//проверка на пуст. поля
    $msg = "Заполните поля";
  } else {
    if (!$blog->saveArt($title, $author, $categ, $text)) {
    	$msg = "Данные не записались в бд";
    } else {
      header("Location: ".$_SERVER["REQUEST_URI"]);//кроме adm пер-х GET нету
      exit;
    }
  }
}
?>

<fieldset>
<legend>Добавить статью</legend>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
  <select name="category">
    <?php
      $arr = $blog->getCategories();
      foreach ($arr as $item) {
        echo "<option value=\"{$item['id']}\">{$item['category']}</option>";
      }
    ?>
  </select><br>
    <input type="text" name="author" placeholder="author"><br>
    <input type="text" name="title" placeholder="title"><br>
    <textarea name="text_art" placeholder="text"></textarea><br>
    <input type="submit" value="Создать">
  </form>
</fieldset>

<?php
//Вывод всех статей
$arr = $blog->getArts();
if (!$arr) {
  $msg = "Ошибка получения данных из бд";
} else {
  echo "<ul class='arts'>";
  foreach ($arr as $item) {
    echo "<li>{$item['title']}</li>";
  }
  echo "</ul>";
	// show_arts_admin($arr);
}
