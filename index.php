<?php

use DI\Container;
use Psr\Container\ContainerInterface;
use App\Settings\Settings;
use App\Data\DataContext;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

require __DIR__ . '/vendor/autoload.php';

//Crea el Container de la aplicacion usando PHP-DI
$container = new Container();

$container->set('settings', function(){
    $settings = require __DIR__ . '/app/settings.php';
    return new Settings($settings);
});

//Agregamos el servicio motor Twing
$container->set('view', function(){
    return Twig::create('src/Views/', ['cache' => false]);
});

//Agregamos el servicio de contexto de db
$container->set('db', function(ContainerInterface $container){
    return new DataContext($container->get('settings')->get());
});

//Configura the application via container
$app = AppFactory::createFromContainer($container);

$app->addRoutingMiddleware();

$routes = require __DIR__ . '/app/routes.php';
$routes($app);

$app->addErrorMiddleware(true, true, true);
$app->run();