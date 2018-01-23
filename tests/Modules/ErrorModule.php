<?php

namespace Tests\Modules;


use Framework\Router;

class ErrorModule extends \PHPUnit\Framework\TestCase
{
    public function __construct(Router $router)
    {
        $router->get('/demo',function (){ return new \stdClass();},'demo');
    }
}