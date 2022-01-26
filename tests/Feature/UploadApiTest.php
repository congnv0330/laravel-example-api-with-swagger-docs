<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UploadApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_can_be_uploaded()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user, 'api')->postJson('/api/upload/image', [
            'file' => $file
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll('path', 'url'));

        Storage::assertExists($response->json('path'));
    }

    public function test_image_upload_only_accept_image_type()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('danger.php');

        $response = $this->actingAs($user, 'api')->postJson('/api/upload/image', [
            'file' => $file
        ]);

        $response->assertStatus(422);
    }
}
