<?php
//default:
$categ = "";
$author = "";
$title = "";
$text = "";

//Редактируем полученную статью
if (isset($_GET["upd"])) {
  $id = $blog->clearInt($_GET["upd"]);
  $arr = $blog->getArt($id);
  $categ = $arr['category'];
  $author = $arr['author'];
  $title = $arr['title'];
	$text = $arr['text_art'];
}
?>

<fieldset>
<legend>Редактировать статью</legend>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
    <!-- <input type="hidden" name="id" value="<?=$id?>"> мона так-->
    <select name="category">
    <?php
      $arr = $blog->getCategories();
      foreach ($arr as $item) {
        if ($categ == $item["category"]) {
          echo "<option value=\"{$item['id']}\" selected>{$item['category']}</option>";
        } else {
          echo "<option value=\"{$item['id']}\">{$item['category']}</option>";
        }
      }
    ?>
    </select><br>
      <input type="text" name="author" value="<?=$author?>" placeholder="author"><br>
      <input type="text" name="title" value="<?=$title?>" placeholder="title"><br>
      <textarea name="text_art" placeholder="text"><?=$text?></textarea><br>
    <input type="submit" value="Редактировать">
  </form>
</fieldset>

<?php
//Пересохранение статьи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $blog->clearStr($_POST["title"]);
  $author = $blog->clearStr($_POST["author"]);
  $categ = $blog->clearInt($_POST["category"]);
  $text = $blog->clearStr($_POST["text_art"]);
  // $id = $_POST["id"];//уже известно
  if (empty($title) and empty($author) and empty($text)) {//проверка на пуст. поля
    $msg = "Заполните поля";
  } else {
	  $blog->updArt($id, $title, $author, $categ, $text);
    header("Location: ".$_SERVER['PHP_SELF']."?adm=2");
    exit;
  }
}

//Вывод всех статей со ссылкой редактирования
$arr = $blog->getArts();
if (!$arr) {
  $msg = "Ошибка получения из бд";
} else {
  echo "<ul class='arts'>";
  foreach ($arr as $item) {
    echo "<li>{$item['title']} <a href=\"{$_SERVER['PHP_SELF']}?adm=2&upd={$item['id']}\">Редактировать</a></li>";
  }
  echo "</ul>";
	// show_arts_admin($arr, "<a href=\"{$_SERVER['REQUEST_URI']}&upd={$item['id']}\">Редактировать</a>");
}