<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class JSONTest extends TestCase {

    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_get_categories_by_supplier_call_returns_a_successful_response() {

        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->json('GET', '/get-categories-by-supplier', [
            "supplier_id" => $supplier->id
        ]);

        $response->assertOk();
    }

    public function test_get_products_by_supplier_and_category_call_returns_a_successful_response() {

        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->json('GET', '/get-products-by-supplier-and-category', [
            "supplier_id" => $supplier->id,
            "category_id" => $category->id
        ]);

        $response->assertOk();
    }

    public function test_get_products_by_category_call_returns_a_successful_response() {

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->json('GET', '/get-products-by-category', [
            "category_id" => $category->id
        ]);

        $response->assertOk();
    }

    public function test_get_product_available_qty_call_returns_a_successful_response() {

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->json('GET', '/get-product-available-qty', [
            "product_id" => $product->id
        ]);

        $response->assertOk();
    }

}
