<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        //Attempt to generate a unique invoice ID
        $invoice_id = (int) substr((string) time(), -5);

        return [
            'invoice_no' => $invoice_id,
            'invoice_date' => now(),
            'comments' => Str::random(10),
            'status_id' => 1 //1 = Pending
        ];
    }
}
