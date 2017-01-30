<fieldset>
<legend>Добавить комментарий</legend>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
    <input type="text" name="nick" placeholder="Nick"><br>
    <textarea name="comment" placeholder="Comment"></textarea><br>
    <input type="submit">
  </form>
</fieldset>

<?php
//создание:
$idArt = $_GET["id"];
if ($_SERVER['REQUEST_METHOD'] =="POST") {
  if (!empty($_POST["nick"]) and !empty($_POST["comment"])) {//если поля не пуст.
    $nick = $blog->clearStr($_POST["nick"]);
    $comment = $blog->clearStr($_POST["comment"]);
    $dt = time();
    $str = "$idArt|$dt|$nick|". base64_encode($comment)."\n";//формир. строку
    if (!$blog->saveComm($str))
      $msg = "Комментарий не сохранился";
    header("Location: ".$_SERVER["REQUEST_URI"]);//защита от повтор. посыл. данн.
    exit;
  }
}

//вывод на стр.:
$arr = $blog->getAllComms();
if (!$arr)
  $msg = "Не могу показать комменты";
else {
  $blog->showCommsArt($arr, $idArt);
}

//редактирование:
if (isset($_GET["upd_com"])) {
  //
}