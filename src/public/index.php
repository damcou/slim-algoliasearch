<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
require __DIR__ . '/../../vendor/autoload.php';
session_start();
// Instantiate the app
$app =  new \Slim\App(
    ['settings' =>\App\Helper\Config::getSettings()]
);
// Set up dependencies
require __DIR__ . '/../slim/dependencies.php';
// Register routes
require __DIR__ . '/../slim/router.php';
// Run app
$app->run();