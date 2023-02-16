<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderStatus;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoiceStatus;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentStatus;
use App\Models\Unit;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class InvoiceTest extends TestCase {

    use RefreshDatabase;
    use WithoutMiddleware;

    public function setUp() : void {
        parent::setUp();
        sleep(1);
    }

    public function test_invoice_all_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $invoice = Invoice::factory()->create();
        $invoice_detail = InvoiceDetail::factory()->create();
        $invoice_status = InvoiceStatus::factory()->create();
        $payment = Payment::factory()->create();
        $payment_detail = PaymentDetail::factory()->create();
        $payment_status = PaymentStatus::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();

        $invoice_status = new InvoiceStatus;
        $invoice_status->id = 2; //Approved
        $invoice_status->status = "Approved";
        $invoice_status->save();

        $invoice->status_id = 2; //Approved
        $invoice->created_by = $user->id;
        $invoice->save();

        $invoice_detail->invoice_id = $invoice->invoice_no;
        $invoice_detail->invoice_date = $invoice->invoice_date;
        $invoice_detail->category_id = $category->id;
        $invoice_detail->product_id = $product->id;
        $invoice_detail->sales_qty = 10;
        $invoice_detail->unit_price = 10;
        $invoice_detail->sales_price = 10;
        $invoice_detail->status_id = 2;
        $invoice_detail->save();

        $payment->invoice_id = $invoice->invoice_no;
        $payment->customer_id = $customer->id;
        $payment->status_id = $payment_status->id; //1
        $payment->payment_amount = 100;
        $payment->due_amount = 100;
        $payment->total_amount = 100;
        $payment->save();

        $payment_status = new PaymentStatus;
        $payment_status->id = 2;
        $payment_status->status = "Due Amount Payment";
        $payment_status->save();

        $payment_status = new PaymentStatus;
        $payment_status->id = 3;
        $payment_status->status = "Partial Payment";
        $payment_status->save();

        $payment_detail->invoice_id = $invoice->invoice_no;
        $payment_detail->payment_date = $payment->payment_date;
        $payment_detail->payment_amount = 100;
        $payment_detail->current_paid_amount = 100;
        $payment_detail->updated_by = $user->id;;
        $payment_detail->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoices/all');

        $response->assertOk();

        $response->assertSee("Invoices");
    }

    public function test_invoice_pending_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $invoice = Invoice::factory()->create();
        $invoice_detail = InvoiceDetail::factory()->create();
        //$invoice_status = InvoiceStatus::factory()->create();
        $payment = Payment::factory()->create();
        $payment_detail = PaymentDetail::factory()->create();
        //$payment_status = PaymentStatus::factory()->create();
        //$unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();

        $invoice->status_id = 1; //Pending
        $invoice->created_by = $user->id;
        $invoice->save();

        $invoice_detail->invoice_id = $invoice->invoice_no;
        $invoice_detail->invoice_date = $invoice->invoice_date;
        $invoice_detail->category_id = $category->id;
        $invoice_detail->product_id = $product->id;
        $invoice_detail->sales_qty = 10;
        $invoice_detail->unit_price = 10;
        $invoice_detail->sales_price = 10;
        $invoice_detail->status_id = 1;
        $invoice_detail->save();

        $payment->invoice_id = $invoice->invoice_no;
        $payment->customer_id = $customer->id;
        $payment->status_id = 1; //1
        $payment->payment_amount = 100;
        $payment->due_amount = 100;
        $payment->total_amount = 100;
        $payment->save();

        $payment_detail->invoice_id = $invoice->invoice_no;
        $payment_detail->payment_date = $payment->payment_date;
        $payment_detail->payment_amount = 100;
        $payment_detail->current_paid_amount = 100;
        $payment_detail->updated_by = $user->id;;
        $payment_detail->save();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoices/pending');

        $response->assertOk();

        $response->assertSee("Pending Invoices");
    }

    public function test_invoice_add_page_returns_a_successful_response() {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoice/create');

        $response->assertOk();

        $response->assertSee("New Invoice");
    }

    public function test_invoice_add_page_can_create_new_invoice() {

        $user = User::factory()->create();
        $unit = Unit::factory()->create();
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();

        $product->category_id = $category->id;
        $product->supplier_id = $supplier->id;

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/invoice/store', [
            'invoice_date' => (new DateTime)->format("Y-m-d"),
            'invoice_no' => 12345,
            'comments' => "Test",
            'product_id' => [$product->id],
            'category_id' => [$category->id],
            'sales_qty' => [2],
            'unit_price' => [10],
            'sales_price' => [20],
            'status_id' => 1,
            'invoiceDiscountAmount' => 0,
            'invoiceTotal' => 0,
            'payment_status' => 1, //Paid in Full
            'payment_amount' => null,
            'customer_id' => $customer->id,
            'customer_name' => "",
            'customer_phone' => "",
            'customer_email' => ""
        ]);

        $this->assertDatabaseHas('invoices', [
            'invoice_no' => 12345
        ]);

        $response->assertRedirect();
    }

    public function test_invoice_can_be_deleted() {

        $user = User::factory()->create();
        $invoice = Invoice::factory()->create();
        $invoice_detail = InvoiceDetail::factory()->create();
        $product = Product::factory()->create();
        $category = Category::factory()->create();

        $invoice->status_id = 1; //Pending
        $invoice->created_by = $user->id;
        $invoice->save();

        $invoice_detail->invoice_id = $invoice->invoice_no;
        $invoice_detail->invoice_date = $invoice->invoice_date;
        $invoice_detail->category_id = $category->id;
        $invoice_detail->product_id = $product->id;
        $invoice_detail->sales_qty = 10;
        $invoice_detail->unit_price = 10;
        $invoice_detail->sales_price = 10;
        $invoice_detail->status_id = 1;
        $invoice_detail->save();

        $this->assertDatabaseHas('invoices', [
            'invoice_no' => $invoice->invoice_no
        ]);

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoice/delete/' . $invoice->id); //Delete by ID (not invoice number)

        $this->assertDatabaseMissing('invoices', [
            'invoice_no' => $invoice->invoice_no
        ]);

        $response->assertRedirect();
    }

    public function test_invoice_approve_page_returns_a_successful_response() {

        $user = User::factory()->create();
        $invoice = Invoice::factory()->create();
        $invoice_detail = InvoiceDetail::factory()->create();
        $payment = Payment::factory()->create();
        $payment_detail = PaymentDetail::factory()->create();
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();

        $invoice->status_id = 1; //Pending
        $invoice->created_by = $user->id;
        $invoice->save();

        $invoice_detail->invoice_id = $invoice->invoice_no;
        $invoice_detail->invoice_date = $invoice->invoice_date;
        $invoice_detail->category_id = $category->id;
        $invoice_detail->product_id = $product->id;
        $invoice_detail->sales_qty = 10;
        $invoice_detail->unit_price = 10;
        $invoice_detail->sales_price = 10;
        $invoice_detail->status_id = 1;
        $invoice_detail->save();

        $payment->invoice_id = $invoice->invoice_no;
        $payment->customer_id = $customer->id;
        $payment->status_id = 1; //1
        $payment->payment_amount = 100;
        $payment->due_amount = 100;
        $payment->total_amount = 100;
        $payment->save();

        $payment_detail->invoice_id = $invoice->invoice_no;
        $payment_detail->payment_date = $payment->payment_date;
        $payment_detail->payment_amount = 100;
        $payment_detail->current_paid_amount = 100;
        $payment_detail->updated_by = $user->id;
        $payment_detail->save();

        $this->assertDatabaseHas('invoices', [
            'invoice_no' => $invoice->invoice_no
        ]);

        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->invoice_no
        ]);

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoice/approval/' . $invoice->id); //Approve by ID (not invoice number)

        $response->assertOk();
    }

    public function test_pending_invoice_can_be_approved() {

        $user = User::factory()->create();
        $invoice = Invoice::factory()->create();
        $invoice_detail = InvoiceDetail::factory()->create();
        $payment = Payment::factory()->create();
        $payment_detail = PaymentDetail::factory()->create();
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();

        $invoice->status_id = 1; //Pending
        $invoice->created_by = $user->id;
        $invoice->save();

        $invoice_detail->invoice_id = $invoice->invoice_no;
        $invoice_detail->invoice_date = $invoice->invoice_date;
        $invoice_detail->category_id = $category->id;
        $invoice_detail->product_id = $product->id;
        $invoice_detail->sales_qty = 10;
        $invoice_detail->unit_price = 10;
        $invoice_detail->sales_price = 10;
        $invoice_detail->status_id = 1;
        $invoice_detail->save();

        $payment->invoice_id = $invoice->invoice_no;
        $payment->customer_id = $customer->id;
        $payment->status_id = 1; //1
        $payment->payment_amount = 100;
        $payment->due_amount = 100;
        $payment->total_amount = 100;
        $payment->save();

        $payment_detail->invoice_id = $invoice->invoice_no;
        $payment_detail->payment_date = $payment->payment_date;
        $payment_detail->payment_amount = 100;
        $payment_detail->current_paid_amount = 100;
        $payment_detail->updated_by = $user->id;
        $payment_detail->save();

        $this->assertDatabaseHas('invoices', [
            'invoice_no' => $invoice->invoice_no
        ]);

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->post('/invoice/approve/' . $invoice->id); //Approve by ID (not invoice number)

        $response->assertRedirect();
    }

    public function test_invoice_print_page_returns_successful_response() {

        $user = User::factory()->create();
        $invoice = Invoice::factory()->create();
        $invoice_detail = InvoiceDetail::factory()->create();
        $payment = Payment::factory()->create();
        $payment_detail = PaymentDetail::factory()->create();
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();

        $invoice->status_id = 2; //Approved
        $invoice->created_by = $user->id;
        $invoice->save();

        $invoice_detail->invoice_id = $invoice->invoice_no;
        $invoice_detail->invoice_date = $invoice->invoice_date;
        $invoice_detail->category_id = $category->id;
        $invoice_detail->product_id = $product->id;
        $invoice_detail->sales_qty = 10;
        $invoice_detail->unit_price = 10;
        $invoice_detail->sales_price = 10;
        $invoice_detail->status_id = 2;
        $invoice_detail->save();

        $payment->invoice_id = $invoice->invoice_no;
        $payment->customer_id = $customer->id;
        $payment->status_id = 1; //1
        $payment->payment_amount = 100;
        $payment->due_amount = 100;
        $payment->total_amount = 100;
        $payment->save();

        $payment_detail->invoice_id = $invoice->invoice_no;
        $payment_detail->payment_date = $payment->payment_date;
        $payment_detail->payment_amount = 100;
        $payment_detail->current_paid_amount = 100;
        $payment_detail->updated_by = $user->id;
        $payment_detail->save();

        $this->assertDatabaseHas('invoices', [
            'invoice_no' => $invoice->invoice_no
        ]);

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoices/print/' . $invoice->id); //Approve by ID (not invoice number)

        $response->assertOk();
    }

    public function test_invoice_daily_search_page_returns_a_successful_response() {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoices/reports/daily');

        $response->assertOk();

        $response->assertSee("Daily Invoice Report");
    }

    public function test_invoice_daily_search_report_returns_a_successful_response() {

        $user = User::factory()->create();

        $start_date = (new DateTime)->modify("-1 day")->format("Y-m-d");
        $end_date = (new DateTime)->format("Y-m-d");

        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/invoices/reports/daily/search?start_date=' . $start_date . "&end_date=" . $end_date);

        $response->assertOk();

        $response->assertSee("Daily Invoice Report");
    }
}
