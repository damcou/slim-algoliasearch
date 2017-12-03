<?php

// Routes [FRONTEND]
$app->get('/', \App\Controllers\HomeController::class . ':index');

// Routes[BACKEND]
// Guest reachable routes
$app->group('', function() use ($app) {
    $app->get('/admin/login', \App\Controllers\Admin\LoginController::class . ':signIn')
        ->setArgument('title', 'Sign In')
        ->setName('admin_login');

    $app->post('/admin/loginPost', \App\Controllers\Admin\LoginController::class . ':signInPost')
        ->setName('admin_signInPost');
})->add(new \App\Middleware\GuestMiddleware($container));


// Admin reachable routes
$app->group('', function() use ($app) {
    $app->get('/admin', \App\Controllers\Admin\AdminController::class . ':dashboard')
        ->setArguments(['title'=>'Dashboard', 'logged'=> true])
        ->setName('admin');

    $app->get('/admin/add', \App\Controllers\Admin\AdminController::class . ':add')
        ->setArguments(['title', 'Add an application', 'logged'=> true])
        ->setName('admin_add');

    $app->post('/admin/addPost', \App\Controllers\Admin\AdminController::class . ':addPost')
        ->setName('admin_addPost');

    $app->get('/admin/delete', \App\Controllers\Admin\AdminController::class . ':delete')
        ->setArguments(['title', 'Delete an application', 'logged'=> true])
        ->setName('admin_delete');

    $app->post('/admin/deleteAppPost', \App\Controllers\Admin\AdminController::class . ':deleteAppPost')
        ->setName('admin_deleteAppPost');

    $app->get('/admin/deleteApp', \App\Controllers\Admin\AdminController::class . ':deleteApp')
        ->setName('admin_deleteApp');

    $app->post('/admin/delete', \App\Controllers\Admin\AdminController::class . ':searchPost')
        ->setArguments(['title', 'Delete an application', 'logged'=> true])
        ->setName('admin_searchPost');

    $app->get('/admin/logout', \App\Controllers\Admin\LoginController::class . ':signOut')
        ->setArgument('title', 'Sign Out')
        ->setName('admin_signOut');
})->add(new \App\Middleware\LoggedMiddleware($container));
