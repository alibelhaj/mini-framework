<?php

namespace Framework;

use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var array
     */
    private $modules = [];
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * App constructor.
     * @param string[] $modules
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', substr($uri, 0, -1));
        }
        $router = $this->container->get(Router::class)->match($request);
        if (is_null($router)) {
            return new Response(404, [], '<h1>Error 404</h1>');
        }
        $params = $router->getParameters();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callBack = $router->getCallback();
        if (is_string($callBack)) {
            $callBack = $this->container->get($router->getCallback());
        }
        $response = call_user_func_array($callBack, [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('fatal error');
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
