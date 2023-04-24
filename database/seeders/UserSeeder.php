<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->has
        (Post::factory()->count(5)->has(Photo::factory()->count(3)))->has(Follow::factory()->count(3))->create();
    }
}
