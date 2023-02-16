<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CustomerTest extends TestCase {

    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_customer_all_page_returns_a_successful_response() {

        $customer_status = CustomerStatus::factory()->create(); //Generate the active status

        $response = $this->get('/customers/all');

        $response->assertOk();

        $response->assertSee("Customers - All");
    }

    public function test_customer_credit_all_page_returns_a_successful_response() {

        $response = $this->get('/customers/credit');

        $response->assertOk();

        $response->assertSee("Credit Customers");
    }

    public function test_customer_credit_print_all_page_returns_a_successful_response() {

        $response = $this->get('/customers/credit/print');

        $response->assertOk();

        $response->assertSee("Invoices Due");
    }

    public function test_customer_paid_all_page_returns_a_successful_response() {

        $response = $this->get('/customers/paid');

        $response->assertOk();

        $response->assertSee("Zero-Balance Customers");
    }

    public function test_customer_paid_print_all_page_returns_a_successful_response() {

        $response = $this->get('/customers/paid/print');

        $response->assertOk();

        $response->assertSee("Invoices Paid in Full");
    }

    public function test_customer_report_page_returns_a_successful_response() {

        $response = $this->get('/customers/report');

        $response->assertOk();

        $response->assertSee("Customer Report");
    }

    public function test_customer_report_pdf_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/customers/credit/report/pdf?customer_id=' . $customer->id . '&query_type=customer_paid');

        $response->assertOk();

        $response->assertSee("Invoices Paid in Full");

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/customers/credit/report/pdf?customer_id=' . $customer->id . '&query_type=customer_credit');

        $response->assertOk();

        $response->assertSee("Invoices with Outstanding Balance");
    }

    public function test_customer_add_page_returns_a_successful_response() {

        $response = $this->get('/customer/add');

        $response->assertOk();

        $response->assertSee("Add Customer");
    }

    public function test_customer_add_page_creates_new_customer() {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/customer/store', [
            'name' => "New " . $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'address' => $customer->address,
            'status_id' => $customer->status_id
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => "New " . $customer->name,
        ]);

        $response->assertRedirect();
    }

    public function test_customer_edit_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/customer/edit/' . $customer->id);

        $response->assertOk();

        $response->assertSee("Edit Customer");
        $response->assertSee($customer->name);
    }

    public function test_customer_edit_page_can_update_customer() {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/customer/update', [
            'id' => (int) $customer->id,
            'name' => "Updated - " . $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'address' => $customer->address,
            'status_id' => $customer->status_id
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => "Updated - " . $customer->name,
        ]);

        $response->assertRedirect();
    }

    public function test_customer_delete_request_returns_a_successful_response() {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/customer/delete/' . $customer->id);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);

        $response->assertRedirect();
    }

}
