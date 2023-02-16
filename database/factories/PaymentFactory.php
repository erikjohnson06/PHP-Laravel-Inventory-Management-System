<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'customer_id' => 0,
            'payment_date' => now(),
            'status_id' => 1,
            'payment_amount' => 0,
            'discount_amount' => 0,
            'due_amount' => 0,
            'total_amount' => 0,
            'created_at' => now(),
        ];
    }
}
