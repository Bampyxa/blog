<?php
require_once "libs/data.inc.php";
$sxml = simplexml_load_file(XML_FILE);
?>

<table border="1">
	<tr><th>Название статьи</th>
	<th>Время создания</th>
	<th>Описание статьи</th></tr>
		<?php
		foreach ($sxml->article as $item) {
			echo <<<HEREDOC
			<tr>
				<td>$item->title</td>
				<td>$item->date</td>
				<td>$item->art</td>
			</tr>
HEREDOC;
		}
		?>
</table>