<?php
use Framework\Renderer;

require '../vendor/autoload.php';
$renderer = new Renderer();
$renderer->addPath(dirname(__DIR__).'/views');
$app = new \Framework\App([
    \App\Blog\BlogModule::class
    ], [
        'renderer'=>$renderer
    ]);
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
