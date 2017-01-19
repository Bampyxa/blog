<?php

$arr = get_arts();
if (!$arr) $msg = "Не получены данные из бд";
show_all_arts($arr);