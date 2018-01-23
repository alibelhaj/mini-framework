<?php
namespace Framework\Router;

/**
 * represent match route
 * Class Route
 * @package Framework\Router
 */
class Route
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string|callable
     */
    private $callback;
    /**
     * @var array
     */
    private $parameters;

    /**
     * Route constructor.
     * @param string $name
     * @param string|callable $callback
     * @param array $parameters
     */
    public function __construct(string $name, $callback, array $parameters)
    {

        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string|null
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * list params uri
     * @return string[]
     */
    public function getParameters():array
    {
        return $this->parameters;
    }
}
