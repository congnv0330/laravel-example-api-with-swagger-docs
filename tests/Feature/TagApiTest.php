<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_can_be_get_by_id()
    {
        $tag = Tag::factory()->create();

        $response = $this->getJson('/api/tag/' . $tag->id);

        $response->assertStatus(200);

        $this->assertEquals($tag->id, $response->json('id'));
    }

    public function test_tag_can_be_create()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/api/tag', [
            'name' => 'TagTest'
        ]);

        $response->assertStatus(201);

        $data = $response->json();

        $this->assertArrayHasKey('id', $data);

        $this->assertDatabaseHas('tags', [
            'id' => $data['id']
        ]);
    }

    public function test_tag_can_be_update()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $tag = Tag::factory()->create();

        $response = $this->actingAs($user, 'api')->putJson('/api/tag/' . $tag->id, [
            'name' => 'TagTestUpdate',
            'sort_order' => 2
        ]);

        $tag->refresh();

        $response->assertStatus(200);

        $this->assertEquals($tag->name, 'TagTestUpdate');

        $this->assertEquals($tag->sort_order, 2);
    }

    public function test_tag_can_be_delete()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $tag = Tag::factory()->create();

        $response = $this->actingAs($user, 'api')->delete('/api/tag/' . $tag->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id
        ]);
    }
}
