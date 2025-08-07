<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $user = new User();
        $user -> name = "Juan Andres herrera";
        $user -> email = "juanuper2@gmail.com";
        $user -> email_verified_at = now(); 
        $user -> remember_token = str::random(10);
        $user -> password = bcrypt("123456");

        $user -> save();


        User::factory(10)->create();
        Post::factory(50)->create();
    }
}
