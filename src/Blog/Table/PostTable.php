<?php

namespace App\Blog\Table;

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
     * @return array
     */
    public function findPaginated():array
    {
        return $this->pdo->query("SELECT * FROM posts ORDER BY created_at LIMIT 15 ")->fetchAll();
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
