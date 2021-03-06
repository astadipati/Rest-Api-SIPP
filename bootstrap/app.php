<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
	'settings' => [
			'displayErrorDetails' => true,
            'determineRouteBeforeAppMiddleware' => true,
            'addContentLengthHeader' => true,
			'db'=>[

		  		'driver'=> 'mysql',
		  		'host'=>'localhost',
		  		'database'=>'slimusers',
		  		'username'=> 'root',
		  		'password' => '',
		  		'charset' => 'utf8',
		  		'collation' => 'utf8_unicode_ci',

	]
		]
	]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){
	return $capsule;
};


$container['view'] = function ($container){
	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
			'cache' => false,
		]);
	$view->addExtension(new \Slim\Views\TwigExtension(
			$container->router,
			$container->request->getUri()
		));
	return $view;
};
// validator
$container['validator'] = function ($container){
	return new App\Validation\Validator($container);
};
// home
$container['HomeController'] = function($container){
	return new \App\Controller\HomeController($container);
};
// auth
$container['AuthController'] = function($container){
	return new \App\Controller\Auth\AuthController($container);
};

// csrf
$container ['csrf'] = function ($container)
{
	return new \Slim\Csrf\Guard;
};

$app->add($container->csrf);
// end csrf

// middleware
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));

// double email cek dimari
v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
