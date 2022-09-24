<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Category;
use App\Models\Tag;
use Tests\TestCase;

class AdTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_ads()
    {
        $response = $this->json('GET', '/api/ads')
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Get all ads',
            ]
        );
    }

    public function test_create_ads()
    {
        $advertiser = Advertiser::orderby('created_at', 'desc')->first();
        $category = Category::orderby('created_at', 'desc')->first();
        $tags = Tag::orderby('created_at', 'desc')->first();

        $data = [
            'title' => 'Ad 1',
            'description' => 'Test',
            'advertiser' => $advertiser['id'],
            'category' => $category['id'],
            'start_date' => '2022-09-28',
            'type' => 'free',
            'tags' => $tags['id'],
        ];

        $response = $this->json('POST', '/api/ads', $data)
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Create new ad',
            ]
        );
    }

    public function test_get_ads_by_advertisers()
    {
        $advertiser = Advertiser::get();
        $email = $advertiser[0]['email'];
        $response = $this->json('GET', '/api/ads/show_by_advertiser', ['email' => $email])
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $response->assertJson(
            [
                'code' => 200,
                'message' => "Get ads by advertiser",
            ]
        );
    }

    public function test_filter_ads_by_category()
    {
        $ads = Ad::orderby('created_at', 'desc')->first();
        $category_id = $ads['category'];
        $response = $this->json('GET', '/api/ads/filter_by_category', ['category' => $category_id])
            ->assertStatus(200);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Get ads by category',
            ]
        );
    }

    public function test_filter_ads_by_tag()
    {
        $tags = Tag::orderby('created_at', 'desc')->first();
        $tag_id = $tags['id'];

        $response = $this->json('GET', '/api/ads/filter_by_tag', ['tag' => $tag_id])
            ->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $response->assertJson(
            [
                'code' => 200,
                'message' => 'Get ads by tag',
            ]
        );
    }
}
