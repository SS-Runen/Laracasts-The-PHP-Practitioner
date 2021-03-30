<?php

$pdostmt_sitepages = DBManager::query(
    $tbl="tbl_routes",
    $columns="uri"
);

# echo "<hr><h1>Site Pages Controller Loaded</h1>";
require "./Public/Views/sitepages.view.php";
?>