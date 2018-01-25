<?php
namespace Tests\App\Blog\Actions;

use App\Blog\Actions\BlogAction;
use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Framework\Router\Route;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class BlogActionTest extends TestCase
{
    /**
     * @var
     */
    private $action;
    /**
     * @var
     */
    private $router;
    /**
     * @var
     */
    private $renderer;
    /**
     * @var
     */
    private $postTable;

    public function setUp()
    {
        $this->renderer = $this->prophesize(RendererInterface::class);
//        $this->renderer->render(Argument::any(),Argument::any())->willReturn('');
        $this->postTable = $this->prophesize(PostTable::class);

        $this->router = $this->prophesize(Router::class);

        $this->action = new BlogAction($this->renderer->reveal(), $this->router->reveal(), $this->postTable->reveal());
    }

    public function makePost(int $id, string $slug):Post
    {

        $post = new Post();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function testShowRedirect()
    {
        $poste = $this->makePost(9, 'rerere-erer');

        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', 9)
            ->withAttribute('slug', 'demo');

        $this->router->generateUri(
            'blog.show'
            , ['id' => $poste->id, 'slug' => $poste->slug])
            ->willReturn('/demo2');

        $this->postTable->find($poste->id)->willReturn($poste);

        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/demo2'], $response->getHeader('location'));
 
    }
}