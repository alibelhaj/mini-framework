<?php

namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\paginatedQuery;
use Pagerfanta\Pagerfanta;

class PostTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {

        $this->pdo = $pdo;
    }

    /**
     * @param int $perPage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage):Pagerfanta
    {
        $query = new paginatedQuery(
            $this->pdo,
            'SELECT * FROM posts ORDER BY created_at DESC ',
            'SELECT COUNT(id) FROM posts',
            Post::class
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * @param int $id
     * @return Post
     */
    public function find(int $id):Post
    {
        $sth = $this->pdo->prepare('SELECT * FROM posts WHERE id = ? ');
        $sth->execute([$id]);
        $sth->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $sth->fetch();
    }
}
