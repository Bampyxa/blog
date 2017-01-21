<?php
session_start();
$msg = "";
$login = "root";
$pass = 1234;
$hash = password_hash($pass, PASSWORD_BCRYPT);
//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $l = trim(strip_tags($_POST["login"]));
  $p = trim(strip_tags($_POST["password"]));
  // if ($l==$login and $p==$pass) {
  if ($l==$login) {
    if (password_verify($p, $hash)) {
      $_SESSION["admin"] = true;
      //header("Location: ".dirname($_SERVER["PHP_SELF"], 2));//php7
      header("Location: ".dirname(dirname($_SERVER["PHP_SELF"])));//php5
      exit;
    } else {
      $msg = "Неправильный логин или пароль";
    }
  } else {
    $msg = "Неправильный логин или пароль";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../style.css">
  <title>Авторизация</title>
</head>
<body>
<p><?=$msg?></p>
<fieldset>
<legend>Вход в админку</legend>
  <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <input type="text" name="login"><br>
    <input type="text" name="password"><br>
    <input type="submit">
  </form>
</fieldset>
</body>
</html>