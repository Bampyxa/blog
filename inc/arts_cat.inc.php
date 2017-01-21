<?php

$arr = $blog->getArtsCat($_GET["cat"]);
if (!$arr) $msg = "Не получены данные из бд";
$blog->showArts($arr);