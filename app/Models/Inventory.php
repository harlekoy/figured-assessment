<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inventory extends Model
{
    use HasFactory;

    /**
     * Type of inventory.
     */
    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_APPLICATION = 'application';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'quantity',
        'unit_price',
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting()
    {
        static::creating(function ($model) {
            // Set the quantity to negative when saving type application to inventory
            if ($model->type === self::TYPE_APPLICATION && $model->quantity > 0) {
                $model->quantity = -$model->quantity;
            }
        });
    }

    /**
     * Get the inventory items.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'inventory_items')
            ->using(InventoryItem::class);
    }
}
