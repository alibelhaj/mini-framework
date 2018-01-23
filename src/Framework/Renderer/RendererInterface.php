<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 22/01/18
 * Time: 20:52
 */
namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * @param string $namespace
     * @param null $path
     */
    public function addPath(string $namespace, ?string $path = null) : void;

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []) : string;

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value) : void;
}
