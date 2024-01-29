<?php

namespace Tests\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Post\Domain\Model\Post;

class PostsTestSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        DB::table('posts')->delete();
        Post::factory(10)->create();
        Model::reguard();
    }
}
