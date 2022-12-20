<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyUnitsRequest;
use App\Http\Resources\ItemResource;
use App\Jobs\RecordApplicationToLedger;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

class ApplyUnitsController extends Controller
{
    /**
     * Handle applying of units.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ApplyUnitsRequest $request)
    {
        try {
            DB::beginTransaction();

            $items = $request->items;

            foreach ($items as $item) {
                $item->update(['applied_at' => now()]);
            }

            // In order to improve efficiency, let's move the action of recording the ledger
            // for historical purposes to background processing. This way, it can be
            // completed without holding up other processes.
            RecordApplicationToLedger::dispatch($request->items, $request->quantity);

            DB::commit();

            return ItemResource::collection($items);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Something went wrong, please try again later.',
            ], 400);
        }
    }
}
