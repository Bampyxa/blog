<?php

$arr = get_arts_cat($_GET["cat"]);
if (!$arr) $msg = "Не получены данные из бд";
show_all_arts($arr);