<?php
// require "./Core/Configuration.php";
// require "./Core/Database/DBManager.php";
// require "./Core/Routing/Router.php";
// require "./Core/FormHandler.php";
// require_once "./Core/Routing/RouteRegistry.php";

# Only scripts in the Core directory are autoloaded.
#These scripts are outside the Core.
include_once "./Public/snippets/head.php";
include_once "./Public/snippets/navbar.php";
require_once "./AppSpecific/App.php";
require_once "./AppSpecific/Controllers/RequestController.php";
require_once "./AppSpecific/Controllers/InputController.php";

// require_once "Configuration.php";
?>