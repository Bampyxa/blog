<?php
session_start();
$msg = "";
$login = "root";
$pass = 1234;
//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $l = $_POST["login"];
  $p = $_POST["password"];
  if ($l==$login and $p==$pass) {
    $_SESSION["admin"] = true;
    //header("Location: ".dirname($_SERVER["PHP_SELF"], 2));//php7
    header("Location: ".dirname(dirname($_SERVER["PHP_SELF"])));//php5
    exit;
  } else {
    $msg = "Неправильный логин или пароль";
  }
}
/* Перенаправление броузера на другую страницу в той же директории, что и
изначально запрошенная */
/*$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
header("Location: http://$host$uri/$extra");
exit;*/

/*echo "REQUEST_URI ".$_SERVER["REQUEST_URI"]."<br>";
echo "DOCUMENT_ROOT ".$_SERVER["DOCUMENT_ROOT"]."<br>";
echo "PATH_INFO ".$_SERVER["PATH_INFO"]."<br>";
echo "php_self ".$_SERVER["PHP_SELF"]."<br>";
echo "script_name ".$_SERVER["SCRIPT_NAME"]."<br>";
echo "http_referer ".$_SERVER["HTTP_REFERER"]."<br>";*/
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
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