<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Supplier;
use App\Models\SupplierStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_supplier_all_page_returns_a_successful_response()
    {

        $supplier_status = SupplierStatus::factory()->create(); //Generate the active status

        $response = $this->get('/suppliers/all');

        $response->assertStatus(200);

        $response->assertSee("Suppliers - All");
    }

    public function test_supplier_add_page_returns_a_successful_response()
    {
        $response = $this->get('/supplier/add');

        $response->assertStatus(200);

        $response->assertSee("Add Supplier");
    }

    public function test_supplier_add_page_creates_new_supplier() {

        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/supplier/store', [
                        'name' => $supplier->name,
                        'phone' => $supplier->phone,
                        'email' => $supplier->email,
                        'status_id' => 1
        ]);

        $this->assertDatabaseHas('suppliers', [
                'name' => $supplier->name,
                ]);

        $response->assertRedirect();
    }

    public function test_supplier_edit_page_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/supplier/edit/' . $supplier->id);

        $response->assertStatus(200);

        $response->assertSee("Edit Supplier");
        $response->assertSee($supplier->name);
    }

    public function test_supplier_edit_page_can_update_category()
    {
        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();

        $updated_name = "Updated - " . $supplier->name;

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/supplier/update', [
                    'id' => (int) $supplier->id,
                    'name' => $updated_name,
                    'phone' => $supplier->phone,
                    'email' => $supplier->email,
                    'status_id' => 1
                ]);

        $this->assertDatabaseHas('suppliers', [
                'name' => $updated_name,
                ]);

        $response->assertRedirect();
    }

    public function test_supplier_delete_request_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/supplier/delete/' . $supplier->id);

        $this->assertDatabaseMissing('suppliers', [
                'id' => $supplier->id,
                ]);

        $response->assertRedirect();
    }
}
