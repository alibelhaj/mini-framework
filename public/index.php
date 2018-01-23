<?php
use DI\ContainerBuilder;
use Framework\Renderer\RendererInterface;

require '../vendor/autoload.php';
$modules = [
    \App\Blog\BlogModule::class
];
$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__).'/config/config.php');
foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$container = $builder->build();
$app = new \Framework\App($container, $modules);
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
