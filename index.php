<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "libs/ClassBlog.inc.php";//function for work with db
$blog = new Blog();//получ-е объ. здесь т.к. route.inc исп-ет бд
require_once "libs/data.inc.php";//connect db
require_once "libs/route_site.inc.php";//work with db
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
		<menu>
			<?php
				$blog->menu($link_cats, "hor");
				?>
		</menu>
		<main class="clearfix">
			<aside>
				<?php
				$blog->menu($links);
				?>
				<h3>Курсы валют</h3>
				<ul>
					<?php
						require_once "inc/service-valute.inc.php";
					?>
				</ul>
			</aside>
			<div class="content">
				<h2><?=$header?></h2>
				<section>
					<?php
					require_once $include;
					if (isset($_GET["id"]))//на стр. статьи
						require_once "inc/comm.inc.php";//подкл.коммент.
					?>
				</section>
				<p class="msg"><?=$msg?></p>
			</div>
		</main>
		<footer>
			<p>Copyright my site.</p>
			<?php
			$blog->menu($links, "hor");
			?>
		</footer>
	</div>
</body>
</html>