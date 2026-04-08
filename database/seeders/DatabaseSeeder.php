<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(4)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Post::factory(10)->create();

        Category::factory(5)->create();
        Recipe::factory(25)->create();
        Tag::factory(50)->create();

        $recipes = Recipe::all();
        $tags = Tag::all();

        foreach ($recipes as $recipe) {
            $recipe->tags()->attach($tags->random(rand(2, 4)));
        }
    }
}
