<?php
function menu($arr, $direction="vert") {
	echo "<ul class='menu {$direction}'>";
	foreach ($arr as $item) {
	echo <<<HEREDOC
		<li><a href="{$item['link']}">{$item['name']}</a></li>
HEREDOC;
	}
	echo "</ul>";
}

function get($file) {
  $arr = file($file);
  return $arr;
}

function show_all_arts($arr) {
	echo "<article>";
	foreach ($arr as $item) {
		list($title, $date, $art) = explode("|", $item);
		$date = date("r", $date);
		$art = base64_decode($art);
		echo <<<HEREDOC
		<p><strong>{$title}</strong> <em>{$date}</em></p>
		$art
HEREDOC;
	}
	echo "</article>";
}
