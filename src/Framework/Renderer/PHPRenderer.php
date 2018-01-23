<?php

namespace Framework\Renderer;

class PHPRenderer implements RendererInterface
{
    private $paths = [];
    const DEFAULT_NAMESPACE = '__MAIN';
    private $globals = [];

    public function __construct(?string $defaultPath = null)
    {
        if (!is_null($defaultPath)) {
            $this->addPath($defaultPath);
        }
    }



    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view).'.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.php';
        }
        ob_start();
        extract($this->globals);
        extract($params);
        $renderer = $this;
        require  $path;
        return ob_get_clean();
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0] ==="@";
    }

    private function getNamespace(string $view):string
    {
        return substr($view, 1, strpos($view, '/') -1);
    }

    private function replaceNamespace(string $view):string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@'.$namespace, $this->paths[$namespace], $view);
    }

    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }

    /**
     * @param string $namespace
     * @param null $path
     */
    public function addPath(string $namespace, ?string $path = null) : void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }
}
