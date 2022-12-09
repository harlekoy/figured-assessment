<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement([
                Inventory::TYPE_PURCHASE, Inventory::TYPE_APPLICATION
            ]),
            'quantity' => $this->faker->numberBetween(2, 20),
            'unit_price' => $this->faker->numberBetween(4, 10),
        ];
    }
}
