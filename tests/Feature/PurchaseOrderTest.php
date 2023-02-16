<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderStatus;
use App\Models\Unit;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase {

    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_purchase_order_all_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $purchase_order = PurchaseOrder::factory()->create();
        $purchase_order_status = PurchaseOrderStatus::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $purchase_order->status_id = $purchase_order_status->id;
        $purchase_order->product_id = $product->id;
        $purchase_order->supplier_id = $supplier->id;
        $purchase_order->category_id = $category->id;
        $purchase_order->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/purchaseorders/all');

        $response->assertOk();

        $response->assertSee("Purchase Orders - All");
    }

    public function test_purchase_order_approval_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $purchase_order = PurchaseOrder::factory()->create();
        //$purchase_order_status = PurchaseOrderStatus::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $purchase_order_status = new PurchaseOrderStatus;

        $purchase_order_status->id = 1; //Pending
        $purchase_order_status->status = "Pending";
        $purchase_order_status->save();

        $purchase_order->status_id = $purchase_order_status->id;
        $purchase_order->product_id = $product->id;
        $purchase_order->supplier_id = $supplier->id;
        $purchase_order->category_id = $category->id;
        $purchase_order->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/purchaseorders/approval');

        $response->assertOk();

        $response->assertSee("Purchase Orders - Approve");
    }

    public function test_purchase_order_approval_can_approve_pending_purchase_order() {

        $user = User::factory()->create();
        $purchase_order = PurchaseOrder::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $purchase_order->status_id = 1;
        $purchase_order->product_id = $product->id;
        $purchase_order->supplier_id = $supplier->id;
        $purchase_order->category_id = $category->id;
        $purchase_order->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/purchaseorders/approve/' . $purchase_order->id);

        $response->assertRedirect();
    }

    public function test_purchase_order_delete_can_delete_pending_purchase_order() {

        $user = User::factory()->create();
        $purchase_order = PurchaseOrder::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $purchase_order->status_id = 1;
        $purchase_order->product_id = $product->id;
        $purchase_order->supplier_id = $supplier->id;
        $purchase_order->category_id = $category->id;
        $purchase_order->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/purchaseorder/delete/' . $purchase_order->id);

        $response->assertRedirect();
    }

    public function test_purchase_order_cancel_can_cancel_pending_purchase_order() {

        $user = User::factory()->create();
        $purchase_order = PurchaseOrder::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $purchase_order->status_id = 1;
        $purchase_order->product_id = $product->id;
        $purchase_order->supplier_id = $supplier->id;
        $purchase_order->category_id = $category->id;
        $purchase_order->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/purchaseorder/cancel/' . $purchase_order->id);

        $response->assertRedirect();
    }

    public function test_purchase_order_create_page_returns_a_successful_response() {

        $response = $this->get('/purchaseorder/create');

        $response->assertStatus(200);

        $response->assertSee("New Purchase Order");
    }

    public function test_purchase_order_create_can_create_new_purchase_order() {

        $user = User::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/purchaseorder/store', [
            'po_date' => [(new DateTime)->format("Y-m-d")],
            'po_number' => ["12345"],
            'po_description' => ["Test"],
            'product_id' => [$product->id],
            'supplier_id' => [$supplier->id],
            'category_id' => [$category->id],
            'purchase_qty' => [2],
            'unit_price' => [10],
            'purchase_price' => [20],
            'status_id' => 1
        ]);

        $this->assertDatabaseHas('purchase_orders', [
            'po_number' => "12345"
        ]);

        $response->assertRedirect();
    }

    public function test_purchase_order_daily_report_page_returns_a_successful_response() {

        $response = $this->get('/purchaseorder/reports/daily');

        $response->assertStatus(200);

        $response->assertSee("Purchase Order Invoice Report");
    }

    public function test_purchase_order_daily_report_search_page_returns_a_successful_response() {

        $user = User::factory()->create();

        $start_date = (new DateTime)->format("Y-m-d");
        $end_date = (new DateTime)->modify("+1 day")->format("Y-m-d");

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/purchaseorder/reports/daily/search?start_date=' . $start_date . '&end_date=' . $end_date);

        $response->assertStatus(200);

        $response->assertSee("Daily Purchase Order Report");
    }
}
