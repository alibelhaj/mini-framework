<?php

namespace Tests\Framework;


use Framework\App;
use Framework\BlogModule;
use GuzzleHttp\Psr7\ServerRequest;

class AppTests extends \PHPUnit\Framework\TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET','/demoslash/');
        $response = $app->run($request);
        $this->assertContains('/demoslash',$response->getHeader('Location'));
        $this->assertEquals(301,$response->getStatusCode());
    }

    public function testBlog()
    {
        if (!class_exists(\App\Blog\BlogModule::class))
        {
            echo "exist";
        }

        $app = new App([ \App\Blog\BlogModule::class ]);
        $request = new ServerRequest('GET','/blog');
        $response = $app->run($request);
        $this->assertContains('<h1>Bienvenu sur le blog</h1>',(string) $response->getBody());
        $this->assertEquals(200,$response->getStatusCode());

        $requestSingle = new ServerRequest('GET','/blog/article-de-test');
        $responseSingle = $app->run($requestSingle);

        $this->assertContains('<h1>Bienvenu sur l\'article article-de-test</h1>',(string) $responseSingle->getBody());
        $this->assertEquals(200,$responseSingle->getStatusCode());
    }

    public function testThrowExcepionIfNotResponseSet()
    {
        $app = new App([ \Tests\Modules\ErrorModule::class]);
        $request = new ServerRequest('GET','/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

}
