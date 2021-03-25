<?php
require "./Core/Bootstrap.php";

$passed_uri = $_SERVER["REQUEST_URI"];
$controller_path = Router::returnPath($passed_uri)["path"];
//require $controller_path;

?>