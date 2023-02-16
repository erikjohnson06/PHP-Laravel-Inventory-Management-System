<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'po_number' => Str::random(10),
            'po_date' => now(),
            'po_description' => Str::random(10),
            'product_id' => 1,
            'supplier_id' => 1,
            'category_id' => 1,
            'purchase_qty' => 10,
            'unit_price' => 10.00,
            'purchase_price' => 100.00,
            'product_id' => 1,
            'status_id' => 2 //1 = Pending
        ];
    }
}
