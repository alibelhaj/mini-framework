<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{

    public function run()
    {
        $data=[];
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<1000; $i++) {
            $data[] = [
            'name' =>$faker->title(),
            'slug' =>$faker->slug(),
            'content' =>$faker->text(3000),
            'created_at' =>date('Y-m-d H:i:s', $faker->unixTime('now')),
            'updated_at' =>date('Y-m-d H:i:s', $faker->unixTime('now')),
            ];
        }

        $this->table('posts')
            ->insert($data)
        ->save();
    }
}
