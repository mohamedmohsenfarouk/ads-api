<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_tags()
    {
        $response = $this->json('GET', '/api/tags')
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Get all tags',
            ]
        );
    }

    public function test_create_tag()
    {
        $data = [
            'name' => 'Tag 1'
        ];

        $response = $this->json('POST', '/api/tags', $data)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Create new tag',
            ]
        );
    }

    public function test_update_tag()
    {
        $data = [
            'name' => 'Test update tag'
        ];
        $tags = Tag::orderby('created_at', 'desc')->first();
        $id = $tags['id'];

        $response = $this->json('PUT', '/api/tags/' . $id, $data)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Update tag',
            ]
        );
    }

    public function test_delete_tag()
    {
        $tags = Tag::orderby('created_at', 'asc')->first();
        $id = $tags['id'];
        $response = $this->json('Delete', '/api/tags/' . $id)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Tag deleted successfully',
            ]
        );
    }
}
