<?php

function get($file) {
  $arr = file($file);
  return $arr;
}

function save($file, $xml, $data, $end_file=FILE_APPEND) {
  file_put_contents($file, $data, $end_file);
  create_xml($file, $xml);
}

function del($arr, $id) {
  unset($arr[$id]);
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

function show($arr, $page, $action, $act_name) {
  for ($i=0, $cnt=count($arr); $i<$cnt; $i++) {
    list($title, $_, $_) = explode("|", $arr[$i]);
    echo <<<HEREDOC
    <li>{$title} <a href='{$_SERVER['PHP_SELF']}?adm={$page}&{$action}={$i}'>{$act_name}</a></li>
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

function create_xml($file, $xml) {
  $dom = new DomDocument("1.0", "utf-8");
  $dom->formatOutput = true;
  $dom->preserveWhiteSpace = false;
  //
  $root = $dom->createElement("articles");
  $dom->appendChild($root);
  //
  $arr = get($file);
  if (!$arr) return false;
  foreach ($arr as $item) {
    list($title, $date, $art) = explode("|", $item);
    $item = $dom->createElement("article");
    //
    $_title = $dom->createElement("title", $title);
    $_date = $dom->createElement("date", date("r", $date));
    $_art = $dom->createElement("art");
    $cdata = $dom->createCDATASection(base64_decode($art));
    $_art->appendChild($cdata);
    //
    $item->appendChild($_title);
    $item->appendChild($_date);
    $item->appendChild($_art);
    //
    $root->appendChild($item);
  }
  $dom->save($xml);
}