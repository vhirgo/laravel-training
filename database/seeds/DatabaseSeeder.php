<?php

use App\{User, Task, Blog, Product};
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
        factory(Product::class, 5)->create();

        User::insert([
            'email' => 'root@example.com',
            'name' => 'Administrator',
            'password' => bcrypt('secret'),
        ]);
    }
}
