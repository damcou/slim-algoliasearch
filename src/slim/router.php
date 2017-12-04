<?php

// Routes [FRONTEND]
$app->get('/', \App\Controllers\HomeController::class . ':index');

// Routes[BACKEND]
// API routes
$app->group('', function() use ($app) {
    $app->post('/api/1/apps', \App\Controllers\Api\ApplicationController::class . ':addApplication')
        ->setName('api_add');

    $app->delete('/api/1/apps/{id}', \App\Controllers\Api\ApplicationController::class . ':deleteApplication')
        ->setName('api_delete');
})->add(new \App\Middleware\ApiMiddleware($container));

// Routes[BACKOFFICE]
// Guest reachable routes
$app->group('', function() use ($app) {
    $app->get('/admin/login', \App\Controllers\Admin\LoginController::class . ':signIn')
        ->setArgument('title', 'Sign In')
        ->setName('admin_login')
        ->add($app->getContainer()->get('guardtokens'))
        ->add($app->getContainer()->get('csrf'));

    $app->post('/admin/loginPost', \App\Controllers\Admin\LoginController::class . ':signInPost')
        ->setName('admin_signInPost')
        ->add($app->getContainer()->get('guardtokens'))
        ->add($app->getContainer()->get('csrf'));
})->add(new \App\Middleware\GuestMiddleware($container));

// Admin reachable routes
$app->group('', function() use ($app) {
    $app->get('/admin', \App\Controllers\Admin\AdminController::class . ':dashboard')
        ->setArguments(['title'=>'Dashboard', 'logged'=> true])
        ->setName('admin');

    $app->get('/admin/add', \App\Controllers\Admin\AdminController::class . ':add')
        ->setArguments(['title' => 'Add an application', 'logged'=> true])
        ->setName('admin_add')
        ->add($app->getContainer()->get('guardtokens'))
        ->add($app->getContainer()->get('csrf'));

    $app->post('/admin/addPost', \App\Controllers\Admin\AdminController::class . ':addPost')
        ->setName('admin_addPost')
        ->add($app->getContainer()->get('guardtokens'))
        ->add($app->getContainer()->get('csrf'));

    $app->get('/admin/delete', \App\Controllers\Admin\AdminController::class . ':delete')
        ->setArguments(['title' => 'Delete an application', 'logged'=> true])
        ->setName('admin_delete')
        ->add($app->getContainer()->get('guardtokens'))
        ->add($app->getContainer()->get('csrf'));

    $app->post('/admin/deleteAppPost', \App\Controllers\Admin\AdminController::class . ':deleteAppPost')
        ->setName('admin_deleteAppPost')
        ->add($app->getContainer()->get('guardtokens'))
        ->add($app->getContainer()->get('csrf'));

    $app->get('/admin/deleteApp', \App\Controllers\Admin\AdminController::class . ':deleteApp')
        ->setName('admin_deleteApp');

    $app->post('/admin/delete', \App\Controllers\Admin\AdminController::class . ':searchPost')
        ->setArguments(['title'=> 'Delete an application', 'logged'=> true])
        ->setName('admin_searchPost');

    $app->get('/admin/logout', \App\Controllers\Admin\LoginController::class . ':signOut')
        ->setArgument('title', 'Sign Out')
        ->setName('admin_signOut');
})->add(new \App\Middleware\LoggedMiddleware($container));
