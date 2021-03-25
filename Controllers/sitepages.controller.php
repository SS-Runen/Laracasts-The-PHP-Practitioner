<?php

$pdostmt_sitepages = DBManager::query(
    $tbl="tbl_routes",
    $columns="uri"
);

require "./Public/Views/sitepages.view.php";
?>