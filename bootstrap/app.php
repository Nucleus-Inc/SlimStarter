<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost:8889',
            'database' => 'slimstarter',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
         ]
    ]
]);

$container = $app ->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){
    
    return $capsule;
};

$container['view'] = function($container){

    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views', [
        'cache' => false
    ]);

    $view->AddExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['HomeController'] = function($container){

    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){

    return new \App\Controllers\Auth\AuthController($container);
};


require __DIR__ . '/../app/routes.php';