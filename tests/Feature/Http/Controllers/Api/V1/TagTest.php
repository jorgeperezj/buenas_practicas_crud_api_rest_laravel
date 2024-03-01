<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\Tag;
use App\Models\User;
use laravel\Sanctum\Sanctum;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $tags = Tag::factory(2)->create();
        $response = $this->getJson('/api/V1/tags');
        $response->assertJsonCount(2, 'data')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => ['name'],
                        'relations' => [
                            'recipes' => []
                        ]
                    ]
                ]
        ]);
    }

    public function test_show(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $tag = Tag::factory()->create();
        $response = $this->getJson('/api/V1/tags/' . $tag->id);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'attributes' => ['name'],
                    'relations' => [
                        'recipes' => []
                    ]
                ]
        ]);
    }
}
