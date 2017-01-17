<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once 'secure/sess.inc.php';
require_once 'secure/data.inc.php';
require_once 'secure/lib.inc.php';
// ob_start();

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
	<h4><?=$header?></h4>
	<ul>
		<li><a href="<?=$_SERVER['PHP_SELF']?>?adm=1">Save</a></li>
		<li><a href="<?=$_SERVER['PHP_SELF']?>?adm=2">Edit</a></li>
		<li><a href="<?=$_SERVER['PHP_SELF']?>?adm=3">Delete</a></li>
		<li><a href="<?=$_SERVER['PHP_SELF']?>?logout">Logout</a></li>
	</ul>
	<ul class="arts">
		<?php
			if (isset($_GET["adm"])) {
				require_once $include;
			}
			if (isset($_GET["logout"])) {
				logout();
			}
   // ob_flush();
		?>
	</ul>
</body>
</html>