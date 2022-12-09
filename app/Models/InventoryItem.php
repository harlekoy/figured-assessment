<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InventoryItem extends Pivot
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_items';
}
