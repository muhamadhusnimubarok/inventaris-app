<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'total',
        'repair',
        'available',
    ];
    public function category(): BelongsTo
    {
        return
            $this->belongsTo(Category::class);
    }
    public function lendingDetails(): HasMany
    {
        return $this->hasMany(LendingDetail::class);
    }

    public function refreshAvailable()
    {
        $ongoingLending = $this->lendingDetails()
            ->whereHas('lending', fn($q) => $q->whereNull('return_date'))
            ->sum('qty');

        $this->available = $this->total - ($this->repair ?? 0) - $ongoingLending;
        $this->save();
    }
    protected static function booted()
    {
        static::saved(function ($item) {
            if ($item->isDirty(['total', 'repair'])) {
                $item->refreshAvailable();
            }
        });
    }
}
