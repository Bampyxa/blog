<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'secure/sess.inc.php';
require_once 'secure/lib.inc.php';
$include = "";
$title = "Админка";
$header = "Доступные действия";
switch ($_GET["adm"]) {
  case "1" :
    $include = "inc/save.inc.php";
    $title .= " | Создание статей";
    $header = "Создать статью";
    break;
  case "2" :
    $include = "inc/upd.inc.php";
    $title .= " | Редактирование статей";
    $header = "Редактировать статью";
    break;
  case "3" :
    $include = "inc/del.inc.php";
    $title .= " | Удаление статей";
    $header = "Удалить статью";
    break;
}
$msg = "";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title><?=$title?></title>
</head>
<body>
	<ul>
		<li><a href="index.php?adm=1">Save</a></li>
		<li><a href="index.php?adm=2">Edit</a></li>
		<li><a href="index.php?adm=3">Delete</a></li>
		<li><a href="index.php?logout">Logout</a></li>
	</ul>
	<h4><?=$header?></h4>
	<ul class="arts">
		<?php
			if (isset($_GET["adm"])) {
				require_once $include;
			}
			if (isset($_GET["logout"])) {
				logout();
			}
		?>
	</ul>
</body>
</html>