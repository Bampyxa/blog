<?php

$arr = $blog->getArts();
if (!$arr) $msg = "Не получены данные из бд";
$blog->showArts($arr);