<?php

namespace App\Blog\Table;

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
            'SELECT * FROM posts',
            'SELECT COUNT(id) FROM posts'
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * @param int $id
     * @return \stdClass[]
     */
    public function find(int $id):\stdClass
    {
        $sth = $this->pdo->prepare('SELECT * FROM posts WHERE id = ? ');
        $sth->execute([$id]);
        return $sth->fetch();
    }
}
