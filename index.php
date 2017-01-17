<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once "libs/data.inc.php";
require_once "libs/lib.inc.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="styles/style.css">
	<title><?=$title?></title>
</head>
<body>
	<div class="wrap">
		<header class="clearfix">
			<div class="logo">MySite</div>
			<div class="descr">This is my new site. I have did it. Come here everybody</div>
		</header>
		<main class="clearfix">
			<aside>
				<?php
				menu($links);
				?>
			</aside>
			<div class="content">
				<h2><?=$header?></h2>
				<section>
					<?php
					require_once $include;
					?>
				</section>
			</div>
		</main>
		<footer>
			<p>Copyright my site.</p>
			<?php
			menu($links, "hor");
			?>
		</footer>
	</div>
</body>
</html>