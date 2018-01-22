<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 22/01/18
 * Time: 14:00
 */

namespace tests\Framework;


use Framework\Renderer;
use PHPUnit\Framework\TestCase;

/**
 * Class RendererTest
 * @package tests\Framework
 */
class RendererTest extends TestCase
{
    private $renderer;

    public function setUp()
    {
        $this->renderer = new Renderer();
        $this->renderer->addPath(__DIR__ . '/views');

    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('salut les gens', $content);
    }

    public function testerRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('salut les gens', $content);
    }

    public function testRenderWithParams()
    {
        $content = $this->renderer->render('demoparams',['nom'=>'Ali']);
        $this->assertEquals('salut Ali', $content);

    }

    public function testRenderWithParamsGlobals()
    {
        $this->renderer->addGlobal('nom','Ali');
        $content = $this->renderer->render('demoparams');
        $this->assertEquals('salut Ali', $content);

    }
}