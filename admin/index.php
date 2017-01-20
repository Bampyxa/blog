<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once 'secure/sess.inc.php';
require_once '../libs/data.inc.php';
require_once '../libs/lib.inc.php';
require_once 'secure/route_adm.inc.php';
// ob_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?=$title_site?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h4><?=$header?></h4>
	<ul>
		<li><a href="index.php?adm=1">Save</a></li>
		<li><a href="index.php?adm=2">Edit</a></li>
		<li><a href="index.php?adm=3">Delete</a></li>
		<li><a href="index.php?logout">Logout</a></li>
	</ul>
	<p class="msg-adm"><?=$msg?></p>
		<?php
			if (isset($_GET["adm"]))
				require_once $include;
   // ob_flush();
		?>
</body>
</html>