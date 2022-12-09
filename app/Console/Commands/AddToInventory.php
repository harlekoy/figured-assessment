<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Console\Command;

class AddToInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-inventory {quantity} {unit_price?} {--type=purchase}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will add items to the inventory based on the unit price.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $quantity = $this->argument('quantity');

        $items = $this->getTypeItems($quantity);

        $inventory = Inventory::create([
            'type'       => $this->option('type'),
            'quantity'   => $quantity,
            'unit_price' => $this->argument('unit_price'),
        ]);

        $inventory->items()->attach($items->pluck('id'));

        return Command::SUCCESS;
    }

    /**
     * Get the items based on the inventory type.
     *
     * @param  integer $quantity
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function getTypeItems($quantity)
    {
        $type = $this->option('type');

        if ($type === Inventory::TYPE_PURCHASE) {
            return Item::bulkCreate($quantity, [
                'price' => $this->argument('unit_price'),
            ]);
        } elseif ($type === Inventory::TYPE_APPLICATION) {
            return Item::available($quantity)->get()
                ->tap(function ($items) {
                    $items->each->update(['applied_at' => now()]);
                });
        }

        return collect();
    }
}
