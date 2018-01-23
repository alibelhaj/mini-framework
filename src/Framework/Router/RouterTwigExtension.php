<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 23/01/18
 * Time: 12:43
 */

namespace Framework\Router;

use Framework\Router;

class RouterTwigExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
           new \Twig_SimpleFunction('path', [$this, 'path'])
        ];
    }

    public function path(string $path, array $params = []):string
    {
        return $this->router->generateUri($path, $params);
    }
}
