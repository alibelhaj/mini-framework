<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\Route;
use Framework\Router\RouterTwigExtension;
use Interop\Container\ContainerInterface;

return [
    'database.host' => 'localhost',
    'database.username' => 'jimmy',
    'database.name' => 'framework',
    'database.password' => "test123",
    'views.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
        DI\get(RouterTwigExtension::class)
    ],
    Route::class => \DI\object(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    \PDO::class => function(ContainerInterface $c){
        return new PDO('mysql:host='.$c->get('database.host').';dbname='.$c->get('database.name')
            ,$c->get('database.username'),$c->get('database.password'),
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
            );
    }
];