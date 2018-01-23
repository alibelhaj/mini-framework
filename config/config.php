<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\Route;
use Framework\Router\RouterTwigExtension;

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
    RendererInterface::class => \DI\factory(TwigRendererFactory::class)
];