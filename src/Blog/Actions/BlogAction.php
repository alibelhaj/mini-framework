<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 23/01/18
 * Time: 12:26
 */

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    private $renderer;


    /**
     * @var Router
     */
    private $router;
    /**
     * @var PostTable
     */
    private $postTable;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        } else {
            return $this->index();
        }
    }

    public function index()
    {
        $posts = $this->postTable->findPaginated();

        return $this->renderer->render('@blog/index', ['posts'=>$posts]);
    }


    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface|string
     */
    public function show(ServerRequestInterface $request)
    {
        $slug = $request->getAttribute('slug');
          $post = $this->postTable->find($request->getAttribute('id'));

        if ($post->slug !== $slug) {
            return  $this->redirect('blog.show', ['slug'=>$post->slug,'id'=>$post->id]);
        }
        return $this->renderer->render('@blog/show', ['post' =>$post]);
    }
}
