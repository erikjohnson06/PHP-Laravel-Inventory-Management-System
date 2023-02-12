<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_category_all_page_returns_a_successful_response()
    {
        $response = $this->get('/categories/all');

        $response->assertStatus(200);

        $response->assertSee("Categories - All");
    }

    public function test_category_add_page_returns_a_successful_response()
    {
        $response = $this->get('/category/add');

        $response->assertStatus(200);

        $response->assertSee("Add Category");
    }

    public function test_category_add_page_creates_new_category() {

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/category/store', [
                        'name' => $category->name,
                        'status_id' => $category->status_id
        ]);

        $this->assertDatabaseHas('categories', [
                'name' => $category->name,
                ]);

        $response->assertRedirect();
    }

    public function test_category_edit_page_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/category/edit/' . $category->id);

        $response->assertStatus(200);

        $response->assertSee("Edit Category");
        $response->assertSee($category->name);
    }

    public function test_category_edit_page_can_update_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/category/update', [
                    'id' => (int) $category->id,
                    'name' => "Updated Name",
                    'status_id' => 1
                ]);

        $this->assertDatabaseHas('categories', [
                'name' => "Updated Name",
                ]);

        $response->assertRedirect();
    }

    public function test_category_delete_request_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/category/delete/' . $category->id);

        $this->assertDatabaseMissing('categories', [
                'id' => $category->id,
                ]);

        $response->assertRedirect();
    }
}
