<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesUuid
{
    /**
     * Boot Generates Uuid.
     */
    protected static function bootGeneratesUuid()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::orderedUuid();
        });
    }
}
