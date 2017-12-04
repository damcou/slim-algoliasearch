<?php

$container = $app->getContainer();

// flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages;
};

// admin sessipn
$container['session'] = function($container) {
    return new \App\Helper\Session;
};


// view renderer
$container['view'] = function ($container) {
    $settings = \App\Helper\Config::getSettings();

    // Add Twig template engine
    $view =  new \Slim\Views\Twig(
        $settings['renderer']['template_path'],
        ['cache' => false]
    );

    // Add Twig extension
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container->request->getUri()
    ));

    // Add session
    $view->getEnvironment()->addGlobal('session', [
        'admin_session' => $container->session->check(),
    ]);

    // Add flash messages
    $view->getEnvironment()->addGlobal('flash',  $container->flash);

    return $view;
};

// csrf guard
$container['csrf'] = function($container) {
    return new \Slim\Csrf\Guard;
};

$container['guardtokens'] = function($container) {
    return new \App\Middleware\CsrfGuardMiddleware($container);
};
