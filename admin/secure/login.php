<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
    header("Location: ".dirname($_SERVER["PHP_SELF"], 2));
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

echo "REQUEST_URI ".$_SERVER["REQUEST_URI"]."<br>";
echo "DOCUMENT_ROOT ".$_SERVER["DOCUMENT_ROOT"]."<br>";
echo "PATH_INFO ".$_SERVER["PATH_INFO"]."<br>";
echo "php_self ".$_SERVER["PHP_SELF"]."<br>";
echo "script_name ".$_SERVER["SCRIPT_NAME"]."<br>";
echo "http_referer ".$_SERVER["HTTP_REFERER"]."<br>";
?>

<p><?=$msg?></p>
<fieldset>
<legend>Вход в админку</legend>
  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
    <input type="text" name="login"><br>
    <input type="text" name="password"><br>
    <input type="submit">
  </form>
</fieldset>