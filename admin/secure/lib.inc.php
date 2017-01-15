<?php
const FILE_DB = "../files/arts.txt";

function get($file) {
  $arr = file($file);
  return $arr;
}
function save($file, $data, $end_file=FILE_APPEND) {
  file_put_contents($file, $data, $end_file);
  /*header("Location: ".$_SERVER["REQUEST_URI"]);//убрать del=id
  exit;*/
}
/*function del($file, $arr, $id) {
  unset($arr[$id]);
  save_rows($file, $arr, NULL);
}*/
function del($arr, $id) {
  unset($arr[$id]);
  // save_rows($file, $arr, NULL);
  return $arr;
}
function get_item_for_upd($arr, $id) {
  for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {
    if ($i==$id) {
      return $arr[$i];
    }
  }
}
function upd($arr, $id, $value) {
  for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {
    if ($i==$id) {
      $arr[$i] = $value;
      return $arr;//!!!
    }
  }
}
/*function show($file, $action, $act_name) {
  $arr = get_rows($file);
  echo "<article>";
  for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {
    list($title, $_, $_) = explode("|", $arr[$i]);
    echo <<<HEREDOC
    <p>$arr[$title] <a href='test1.php?{$action}={$i}'>{$act_name}</a></p>
HEREDOC;
  }
  echo "</article>";
}*/

function show($arr, $action, $act_name) {
  // $arr = get_rows($arr);
  for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {
    list($title, $_, $_) = explode("|", $arr[$i]);
    echo <<<HEREDOC
    <li>{$title} <a href='{$_SERVER['PHP_SELF']}?adm=2&{$action}={$i}'>{$act_name}</a></li>
HEREDOC;
  }
}
//Не пойдет т.к. REQUEST_URI = path?adm=2&upd=0...<-&upd=1 с кажд. нов. выбор. стат.
//<li>{$title} <a href='{$_SERVER['REQUEST_URI']}&{$action}={$i}'>{$act_name}</a></li>

function logout() {
  session_destroy();
  header("Location: ".dirname($_SERVER['PHP_SELF'])."/secure/login.php");//-admin
  exit;
}

/*$include = "";
$title = "Админка";
$header = "Доступные действия";
switch ($_GET["adm"]) {
  case "1" :
    $include = "save.inc.php";
    $title .= " | Создание статей";
    $header = "Создать статью";
    break;
  case "2" :
    $include = "edit.inc.php";
    $title .= " | Редактирование статей";
    $header = "Редактировать статью";
    break;
  case "3" :
    $include = "del.inc.php";
    $title .= " | Удаление статей";
    $header = "Удалить статью";
    break;
}*/