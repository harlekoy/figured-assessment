<?php

namespace App\Jobs;

use App\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RecordApplicationToLedger implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Collection $items,
        public int $quantity
    ) {
    }

    /**
     * Record history to ledger/inventory.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $date = $this->items->first()->applied_at;

            $inventory = Inventory::forceCreate([
                'type'       => Inventory::TYPE_APPLICATION,
                'quantity'   => $this->quantity,
                'updated_at' => $date,
                'created_at' => $date,
            ]);

            $inventory->items()->attach($this->items);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
