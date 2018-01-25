<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 25/01/18
 * Time: 01:06
 */

namespace Framework\Twig;

use Framework\Router;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;

class PagerFantaExtension extends \Twig_Extension
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
        return[
        new \Twig_SimpleFunction('paginate', [$this,'paginate'])
        ];
    }

    /**
     * @param Pagerfanta $pagerfanta
     * @param string $route
     * @param array $queryArgs
     * @return string
     */
    public function paginate(Pagerfanta $pagerfanta, string $route, array $queryArgs = []):string
    {
        $view = new TwitterBootstrap4View();
        return $view->render($pagerfanta, function ($page) use ($route, $queryArgs) {
            if ($page>1) {
                $queryArgs['p'] = $page;
            }
            return$this->router->generateUri($route, [], $queryArgs);
        });
    }
}
