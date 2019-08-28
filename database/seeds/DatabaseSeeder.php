<?php

use App\User;
use App\Blog;
use App\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Blog::class, 10)->create();
        factory(Task::class, 82)->create();

        User::insert([
            [
                'email' => 'mul14@refactory.id',
                'name' => 'Mulia Nasution',
                'password' => bcrypt('secret'),
            ],
        ]);
    }
}
