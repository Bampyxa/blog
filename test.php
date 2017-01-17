<?php
const FILE_NAME = "rss.xml";//сюда скач-ся и буд. хран-ся xml-файл
const RSS_URL = "http://site1/Part3/news/news.xml";//адрес откуда скач-ся rss
const RSS_TTL = 3600;
//
function download($path, $file) {
	$str = file_get_contents($path);
	if ($str)
		file_put_contents($file, $str);
}
if (!file_exists(FILE_NAME)) {
	download(RSS_URL, FILE_NAME);
	$sxml = simplexml_load_file(FILE_NAME);
	$i=0;
	echo "<table>";
	foreach ($sxml->channel->item as $item) {
	  echo <<<HEREDOC
	  <tr>
	  <td>{$item->title}</td>
	  <td>{$item->category}</td>
	  <td>{$item->datetime}</td>
	  <td>{$item->description}</td>
	  </tr>
HEREDOC;
	  $i++;
	  if ($i>4) break;
	}
	echo "<table>";
}
if (time() > filemtime(FILE_NAME)+RSS_TTL) {
	download(RSS_URL, FILE_NAME);
	echo "Файл обновился";
}
?>
