<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_categories()
    {
        $response = $this->json('GET', '/api/categories')
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Get all categories',
            ]
        );
    }

    public function test_create_category()
    {
        $data = [
            'name' => 'Category 1',
            'description' => 'Test'
        ];

        $response = $this->json('POST', '/api/categories', $data)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Create new category',
            ]
        );
    }

    public function test_update_category()
    {
        $categories = Category::get();
        $id = $categories[0]->id;
        $data = [
            'name' => 'Test update category'
        ];

        $response = $this->json('PUT', '/api/categories/' . $id, $data)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Update category',
            ]
        );
    }

    public function test_delete_category()
    {
        $categories = Category::get();
        $id = $categories[0]->id;
        $response = $this->json('Delete', '/api/categories/' . $id)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Category deleted successfully',
            ]
        );
    }
}
