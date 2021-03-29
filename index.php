<?php
require "./Core/Bootstrap.php";

echo "<hr>RAW URI:<br>";
var_dump($_SERVER["REQUEST_URI"]);

$passed_uri = preg_split(
    $pattern="[/]", $subject=trim($_SERVER["REQUEST_URI"], '/'),
);

$passed_uri = implode($passed_uri);
echo "<hr>Processed URI:<br>";
var_dump($passed_uri);
// die();
$controller_path = Router::returnPath($passed_uri)->fetch(PDO::FETCH_ASSOC)["path"];
// $controller_path = Router::returnPath("uri_list")->fetch(PDO::FETCH_ASSOC)["path"];

// if (!is_a($controller_path, "String") || is_null($controller_path)) {
//     echo "<h3>Error occured in directing you to \"$passed_uri\". Returning to Home Page.</h3>";
//     require "Controllers/index.controller.php";
// }
echo "<hr>Fetched Filepath:<br>$controller_path";
require $controller_path;

?>