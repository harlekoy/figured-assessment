<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Console\Command;

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
                return [
                    $inventory->id,
                    $inventory->type,
                    $inventory->quantity,
                    $inventory->unit_price,
                    $inventory->created_at->diffForHumans(),
                ];
            })
        );

        $this->info("{$remaining} items remaining");

        return Command::SUCCESS;
    }
}
