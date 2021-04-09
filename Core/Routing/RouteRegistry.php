<?php

Router::mapUriToController(
    $uri="",
    $class_and_func="RequestController@index"
);

Router::mapUriToController(
    $uri="home",
    $class_and_func="RequestController@index"
);

Router::mapUriToController(
    $uri="about",
    $class_and_func="RequestController@about"
);

Router::mapUriToController(
    "site_pages",
    $class_and_func="RequestController@sitemap"
);

Router::mapUriToController(
    "uri_list",
    $class_and_func="RequestController@sitemap"
);

Router::mapUriToController(
    "register",
    $class_and_func="RequestController@registrationForm"
);

Router::mapUriToController(
    "form_handler",
    $class_and_func="InputController@registrationForm"
);

Router::mapUriToController(
    "register_user",
    "InputController@registerUser"
);

// // use Core\Routing\Router;

// Router::makeURI_Table();

// // require "App/Controllers/"

// Router::setRoute(
//     $uri="uri_list",
//     $request_type="GET",
//     $filepath="Controllers/sitepages.controller.php"
// );

// Router::setRoute(
//     $uri="uri_list",
//     $filepath="Controllers/sitepages.controller.php",
//     $request_type="GET"
// );

// Router::setRoute(
//     $uri="register",
//     $filepath="Controllers/registration.controller.php"
// );

// Router::setRoute(
//     $uri="about",
//     $filepath="Controllers/about.controller.php"
// );

// Router::setRoute(
//     $uri="form_controller",
//     $request_type="POST",
//     $filepath="Core/FormHandler.php"
// );
// Router::setRoute(
//     $uri="form_controller",
//     $filepath="Controllers/form.controller.php",
//     $request_type="POST"
// );
?>