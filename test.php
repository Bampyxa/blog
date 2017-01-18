<?php
$arr = ["HTML", "CSS", "JS", "PHP"];
$sql = "INSERT INTO categories (id, category) ";
$i = 1;
$cnt = count($arr);
foreach ($arr as $item) {
  $sql .= " SELECT $i as id, '$item' as category ";
  if ($i<$cnt)
    $sql .= " UNION ";
  $i++;
}
echo $sql;