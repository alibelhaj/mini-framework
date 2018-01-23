<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 23/01/18
 * Time: 12:26
 */

namespace App\Blog\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    private $renderer;
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $slug = $request->getAttribute('slug');
        if ($slug) {
            return $this->show($slug);
        } else {
            return $this->index();
        }
    }

    public function index()
    {
        return $this->renderer->render('@blog/index');
    }

    public function show(string $slug)
    {
        return $this->renderer->render('@blog/show', ['slug' =>$slug]);
    }
}
