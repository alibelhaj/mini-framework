<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 24/01/18
 * Time: 12:22
 */

namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RouterAwareAction
 * @package Framework\Actions
 */
trait RouterAwareAction
{
    /**
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = [])
    {

        $redirectUri = $this->router->generateUri($path, $params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', $redirectUri);
    }
}
