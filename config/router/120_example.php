<?php
/**
 * These routes are for demonstration purpose, to show how routes and
 * handlers can be created.
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "example",

    // All routes in order
    "routes" => [
        [
            "info" => "Sample controler app style",
            "mount" => "app",
            "handler" => "\Anax\Controller\SampleAppController",
        ],
    ]
];
