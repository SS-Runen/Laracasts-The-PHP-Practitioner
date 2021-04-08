<?php

use Core\Routing\Router;

Router::makeURI_Table();

Router::setRoute(
    $uri="",
    $filepath="App/App/"
);

// require "App/Controllers/"

Router::setRoute(
    $uri="uri_list",
    $request_type="GET",
    $filepath="Controllers/sitepages.controller.php"
);

Router::setRoute(
    $uri="uri_list",
    $filepath="Controllers/sitepages.controller.php",
    $request_type="GET"
);

Router::setRoute(
    $uri="register",
    $filepath="Controllers/registration.controller.php"
);

Router::setRoute(
    $uri="about",
    $filepath="Controllers/about.controller.php"
);

// Router::setRoute(
//     $uri="form_controller",
//     $request_type="POST",
//     $filepath="Core/FormHandler.php"
// );
Router::setRoute(
    $uri="form_controller",
    $filepath="Controllers/form.controller.php",
    $request_type="POST"
);
?>