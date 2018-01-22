<?php

namespace Framework;

use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var array
     */
    private $modules = [];
    /**
     * @var Route
     */
    private $router;
    /**
     * App constructor.
     * @param string[] $modules
     */
    public function __construct(array $modules = [], array $dependencies = [])
    {
        $this->router = new Router();
        if (array_key_exists('renderer', $dependencies)) {
            $dependencies['renderer']->addGlobal('router', $this->router);
        }
        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router, $dependencies['renderer']);
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
        $router = $this->router->match($request);
        if (is_null($router)) {
            return new Response(404, [], '<h1>Error 404</h1>');
        }
        $params = $router->getParameters();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $response = call_user_func_array($router->getCallback(), [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('fatal error');
        }
    }
}
