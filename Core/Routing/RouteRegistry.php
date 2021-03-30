<?php
Router::makeURI_Table();

Router::setRoute(
    $uri="",
    $filepath="Controllers/index.controller.php"
);

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
    $uri="feedback",
    $filepath="Controllers/feedback.controller.php"
);

Router::setRoute(
    $uri="form_handler",
    $filepath="Core/FormHandler.php",
    $request_type="POST"
);
?>