<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceDetail>
 */
class InvoiceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'invoice_id' => 0,
            'invoice_date' => now(),
            'product_id' => 1,
            'category_id' => 1,
            'sales_qty' => 1,
            'unit_price' => 10.00,
            'sales_price' => 10.00,
            'status_id' => 1 //0 = Pending
        ];
    }
}
