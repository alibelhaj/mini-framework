<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;

class App
{
    public function run(ServerRequest $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && substr($uri, -1) === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', substr($uri, 0, -1));
            return $response;
        }
        $response = new Response();
        $response->getBody()->write("Bonjour");
        return $response;
    }
}
