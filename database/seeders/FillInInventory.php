<?php

namespace Database\Seeders;

use App\Console\Commands\AddToInventory;
use App\Models\Inventory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class FillInInventory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            Carbon::setTestNow(Arr::pull($data, 'date'));

            Artisan::call(AddToInventory::class, $data);
        }
    }

    /**
     * Get the data to fill in the inventory.
     */
    public function data(): array
    {
        return [
            ['date' => '2020-06-05', 'quantity' => 10, 'unit_price' => 5],
            ['date' => '2020-06-07', 'quantity' => 30, 'unit_price' => 4.5],
            ['date' => '2020-06-08', 'quantity' => 5, '--type' => Inventory::TYPE_APPLICATION],
        ];
    }
}
