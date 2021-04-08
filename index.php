<?php
namespace Core\Routing;

// Options to show warnings/errors.
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Required scripts.
require_once "./vendor/autoload.php";
require_once "./Core/Bootstrap.php";
require_once "./Core/Routing/Router.php";
require_once "./Core/Routing/RouteRegistry.php";

// Standard non-production code for monitoring and testing purposes.
echo "<hr>RAW URI:<br>";
var_dump($_SERVER["REQUEST_URI"]);

$passed_uri = Router::getURI();
echo "<hr>Processed URI:<br>";
var_dump($passed_uri);

echo "<hr>Request Type:<br>";
var_dump(Router::getReqeustType());

Router::callController(
    $uri=$passed_uri,
    $request_type=$_SERVER["REQUEST_URI"]
)
?>