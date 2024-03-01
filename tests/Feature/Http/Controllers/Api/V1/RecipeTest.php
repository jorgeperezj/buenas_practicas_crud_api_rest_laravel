<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use laravel\Sanctum\Sanctum;

class RecipeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Category::factory()->create();
        $recipes = Recipe::factory(2)->create();

        $response = $this->getJson('/api/V1/recipes');
        $response->assertJsonCount(2, 'data')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => [
                            'category',
                            'author',
                            'title',
                            'description',
                            'ingredients',
                            'instructions',
                            'image',
                            'tags'
                        ]
                    ]
                ]
        ]);
    }

    public function test_store(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $data = [
            'category_id'  => $category->id,
            'title'        => $this->faker->sentence,
            'description'  => $this->faker->paragraph,
            'ingredients'  => $this->faker->text,
            'instructions' => $this->faker->text,
            'image'        => UploadedFile::fake()->image('recipe.png'),
            'tags'         => $tag->id,
        ];

        $response = $this->postJson('/api/V1/recipes', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_show(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Category::factory()->create();
        $recipe = Recipe::factory()->create();

        $response = $this->getJson('/api/V1/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'attributes' => [
                        'category',
                        'author',
                        'title',
                        'description',
                        'ingredients',
                        'instructions',
                        'image',
                        'tags'
                    ]
                ]
        ]);
    }

    public function test_update(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $category = Category::factory()->create();
        $recipe = Recipe::factory()->create();

        $data = [
            'category_id'  => $category->id,
            'title'        => 'Updated title',
            'description'  => 'Updated description',
            'ingredients'  => $this->faker->text,
            'instructions' => $this->faker->text,
        ];

        $response = $this->putJson('/api/V1/recipes/' . $recipe->id, $data);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('recipes', [
            'title'        => 'Updated title',
            'description'  => 'Updated description',
        ]);
    }

    public function test_destroy(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Category::factory()->create();
        $recipe = Recipe::factory()->create();

        $response = $this->deleteJson('/api/V1/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
