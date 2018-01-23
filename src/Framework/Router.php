<?php

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\RequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * register and match routes
 * Class Router
 * @package Framework
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param string $path
     * @param string|callable $callable
     * @param string $name
     */
    public function get(string $path, $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     * @param RequestInterface $request
     * @return Router|null
     */
    public function match(RequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if (!$result->isSuccess()) {
            return null;
        }
        return new Route(
            $result->getMatchedRouteName(),
            $result->getMatchedMiddleware(),
            $result->getMatchedParams()
        );
    }

    public function generateUri(string $name, array $params): ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
