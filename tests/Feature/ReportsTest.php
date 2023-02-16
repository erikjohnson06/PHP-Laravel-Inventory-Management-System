<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ReportsTest extends TestCase {

    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_stock_status_page_returns_a_successful_response() {

        $response = $this->get('/stock/report/status');

        $response->assertOk();

        $response->assertSee("Stock Status");
    }

    public function test_stock_status_pdf_page_returns_a_successful_response() {

        $response = $this->get('/stock/report/pdf');

        $response->assertOk();

        $response->assertSee("Stock Status");
    }

    public function test_supplier_report_page_returns_a_successful_response() {

        $response = $this->get('/stock/report/supplier');

        $response->assertOk();

        $response->assertSee("Supplier Product Report");
    }

    public function test_supplier_report_pdf_page_returns_a_successful_response() {

        $response = $this->get('/supplier/report/pdf');

        $response->assertOk();

        $response->assertSee("Supplier Report");
    }

    public function test_product_report_pdf_page_returns_a_successful_response() {

        $response = $this->get('/product/report/pdf');

        $response->assertOk();

        $response->assertSee("Product Report");
    }
}
