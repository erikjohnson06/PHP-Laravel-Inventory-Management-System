<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProductTest extends TestCase {

    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_product_all_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $product_status = ProductStatus::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $product->unit_id = $unit->id;
        $product->supplier_id = $supplier->id;
        $product->category_id = $category->id;
        $product->status_id = $product_status->id;
        $product->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/products/all');

        $response->assertStatus(200);

        $response->assertSee("Products - All");
    }

    public function test_product_add_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/product/add');

        $response->assertStatus(200);

        $response->assertSee("Add Product");
    }

    public function test_product_add_page_creates_new_product() {

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/product/store', [
            'name' => "New " . $product->name,
            'supplier_id' => $product->supplier_id,
            'category_id' => $product->category_id,
            'unit_id' => $product->unit_id,
            'status_id' => $product->status_id
        ]);

        $this->assertDatabaseHas('products', [
            'name' => "New " . $product->name,
        ]);

        $response->assertRedirect();
    }

    public function test_product_edit_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/product/edit/' . $product->id);

        $response->assertStatus(200);

        $response->assertSee("Edit Product");
        $response->assertSee($product->name);
    }

    public function test_product_edit_page_can_update_product() {

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/product/update', [
            'id' => (int) $product->id,
            'name' => "Updated - " . $product->name,
            'supplier_id' => $product->supplier_id,
            'category_id' => $product->category_id,
            'unit_id' => $product->unit_id,
            'status_id' => $product->status_id
        ]);

        $this->assertDatabaseHas('products', [
            'name' => "Updated - " . $product->name
        ]);

        $response->assertRedirect();
    }

    public function test_product_delete_request_returns_a_successful_response() {

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/product/delete/' . $product->id);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $response->assertRedirect();
    }
}
