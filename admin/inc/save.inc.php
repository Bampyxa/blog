<?php

//Сохранение добавленной статьи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $categ = clear_str($_POST["category"]);
  $author = clear_str($_POST["author"]);
  $title = clear_str($_POST["title"]);
  $text = clear_str($_POST["text_art"]);
  if (empty($author) and empty($title) and empty($text)) {//проверка на пуст. поля
    $msg = "Заполните поля";
  } else {
    if (!save_art($title, $author, $categ, $text)) {
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
      $arr = get_categories();
      foreach ($arr as $item) {
        /*if ($categ == $item["category"]) {
          echo "<option value=\"{$item['id']}\" selected>{$item['category']}</option>";
        } else {*/
          echo "<option value=\"{$item['id']}\">{$item['category']}</option>";
        // }
      }
    ?>
  </select><br>
    <input type="text" name="author"><br>
    <input type="text" name="title"><br>
    <textarea name="text_art"></textarea><br>
    <input type="submit" value="Создать">
  </form>
</fieldset>

<?php
//Вывод всех статей
$arr = get_arts();
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
