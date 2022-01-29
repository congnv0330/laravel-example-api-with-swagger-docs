<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_can_be_get_by_id()
    {
        $blog = Blog::factory()->create();

        $response = $this->getJson('/api/blog/' . $blog->id);

        $response->assertStatus(200);

        $this->assertEquals($blog->id, $response->json('id'));
    }

    public function test_blog_can_be_create()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/api/blog', [
            'title' => 'Blog test',
            'description' => 'Blog description',
            'content' => '<p>Hello</p>',
            'tags' => [1, 2]
        ]);

        $response->assertStatus(201);

        $data = $response->json();

        $this->assertArrayHasKey('id', $data);

        $this->assertDatabaseHas('blogs', [
            'id' => $data['id']
        ]);
    }

    public function test_blog_can_be_update()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $blog = Blog::factory()->create();

        $response = $this->actingAs($user, 'api')->putJson('/api/blog/' . $blog->id, [
            'title' => 'Blog test update',
            'description' => 'Blog description',
            'content' => '<p>Hello 1</p>',
            'tags' => [1]
        ]);

        $blog->refresh();

        $response->assertStatus(200);

        $this->assertEquals($blog->title, 'Blog test update');
        $this->assertEquals($blog->description, 'Blog description');
        $this->assertEquals($blog->content, '<p>Hello 1</p>');

        $this->assertDatabaseHas('blog_has_tags', [
            'blog_id' => $blog->id,
            'tag_id' => 1
        ]);
    }

    public function test_blog_can_be_delete()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $blog = Blog::factory()->create();

        $response = $this->actingAs($user, 'api')->delete('/api/blog/' . $blog->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('blogs', [
            'id' => $blog->id
        ]);
    }
}
