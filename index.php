<?php
// Options to show warnings/errors.
error_reporting(E_ALL);
ini_set('display_errors', '1');

require "./Core/Bootstrap.php";

echo "<hr>RAW URI:<br>";
var_dump($_SERVER["REQUEST_URI"]);

$passed_uri = Router::getURI();
echo "<hr>Processed URI:<br>";
var_dump($passed_uri);

echo "<hr>Request Type:<br>";
var_dump(Router::getReqeustType());
// die();
$filepath = Router::returnPath($passed_uri, Router::getReqeustType());
// $filepath = Router::returnPath("uri_list")->fetch(PDO::FETCH_ASSOC)["path"];

// if (!is_a($filepath, "String") || is_null($filepath)) {
//     echo "<h3>Error occured in directing you to \"$passed_uri\". Returning to Home Page.</h3>";
//     require "Controllers/index.controller.php";
// }
echo "<hr>Fetched Filepath:<br>$filepath";
require $filepath;

?>