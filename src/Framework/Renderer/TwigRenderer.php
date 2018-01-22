<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 22/01/18
 * Time: 21:30
 */

namespace Framework\Renderer;

use Framework\Renderer\RendererInterface;

class TwigRenderer implements RendererInterface
{
    private $loader;
    private $twig;
    public function __construct(string $path)
    {
        $this->loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($this->loader);
    }

    /**
     * @param string $namespace
     * @param null $path
     */
    public function addPath(string $namespace, ?string $path = null) : void
    {
         $this->loader->addPath($path, $namespace);
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []) : string
    {
        return $this->twig->render($view.'.html.twig', $params);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value) : void
    {
        $this->twig->addGlobal($key, $value);
    }
}
