<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreatePosteTable extends AbstractMigration
{
    public function change()
    {
        $this->table('posts')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('content', 'text', ['limit'=>MysqlAdapter::TEXT_LONG])
            ->addColumn('created_at', 'datetime')
            ->addColumn('update_at', 'datetime')
        ->create();
    }
}
