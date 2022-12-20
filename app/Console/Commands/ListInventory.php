<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ListInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the inventory list in a table view.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inventories = Inventory::get();
        $remaining = Item::whereNull('applied_at')->count();

        $this->table(
            ['ID', 'Type', 'Quantity', 'Unit Price', 'Date Created'],
            $inventories->map(function ($inventory) {
                $date = $inventory->created_at->diffForHumans();

                return [
                    $inventory->id,
                    $inventory->type,
                    $inventory->quantity,
                    $inventory->unit_price,
                    Str::contains($date, 'year') ? $inventory->created_at->toFormattedDateString() : $date,
                ];
            })
        );

        $this->info("{$remaining} items remaining");

        return Command::SUCCESS;
    }
}
