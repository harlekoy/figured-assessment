<?php

namespace App\Models;

use App\Traits\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Item extends Model
{
    use HasFactory;
    use GeneratesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'uuid',
        'price',
        'applied_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'applied_at' => 'datetime',
    ];

    /**
     * Build create items.
     *
     * @param  integer $quantity
     */
    public static function bulkCreate($quantity, $data): Collection
    {
        return collect(range(1, $quantity))->map(function () use ($data) {
            return self::create($data);
        });
    }

    /**
     * Get the item getting listed in the inventory.
     */
    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class, 'inventory_items')
            ->using(InventoryItem::class);
    }

    /**
     * Scope a query to only include applied items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeApplied($query): Builder
    {
        return $query->whereNotNull('applied_at');
    }

    /**
     * Scope a query to only include available items and lock it
     * so that other won't be able to fetch the selected items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeAvailable($query, $quantity): Builder
    {
        return $query->whereNull('applied_at')
            ->take($quantity)
            ->oldest('id')
            ->lockForUpdate(); // Help us solve race condition by placing pessimistic locking
    }
}
