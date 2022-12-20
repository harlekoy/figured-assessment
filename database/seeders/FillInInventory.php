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
        $data = array_map('str_getcsv', file('database/inventory.csv'));
        $headers = array_shift($data);

        return collect($data)->map(function ($item) {
            return [
                'date'       => Carbon::createFromFormat('d/m/Y', $item[0])->startOfDay(),
                'quantity'   => $item[2],
                'unit_price' => $item[3] ?: null,
                '--type'     => strtolower($item[1]),
            ];
        })->all();
    }
}
