<?= $renderer->render('header'); ?>
<h1>Bienvenu sur le blog</h1>
<ul>
    <li><a href="<?= $router->generateUri('blog.show', ['slug'=>'aeea']) ?>">lien1</a></li>
    <li><a href="<?= $router->generateUri('blog.show', ['slug'=>'pooo']) ?>">lien 2</a></li>
</ul>
<?= $renderer->render('footer'); ?>