<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class LendingDetail extends Model
{
    protected $fillable = [
        'lending_id',
        'item_id',
        'qty',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function lending(): BelongsTo
    {
        return $this->belongsTo(Lending::class);
    }

   protected static function booted()
{
    static::created(function ($lendingDetail) {
        if ($lendingDetail->item) {
            $lendingDetail->item->refreshAvailable();
        }
    });

    static::updated(function ($lendingDetail) {
        if ($lendingDetail->item) {
            $lendingDetail->item->refreshAvailable();
        }
    });

    static::deleted(function ($lendingDetail) {
        if ($lendingDetail->item) {
            $lendingDetail->item->refreshAvailable();
        }
    });
}
    
}
