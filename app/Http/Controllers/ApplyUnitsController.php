<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyUnitsRequest;
use App\Jobs\RecordApplicationToLedger;
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

            foreach ($request->items as $item) {
                $item->update(['applied_at' => now()]);
            }

            // Recording to the ledger for history purposes can wait,
            // so let's move this action to background processing.
            RecordApplicationToLedger::dispatch($request->items, $request->quantity);

            DB::commit();

            return response()->noContent();
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'Something went wrong, please try again later.',
            ], 400);
        }
    }
}
