<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lending extends Model
{
    protected $fillable = [
        'created_by',
        'user_name',
        'loan_date',
        'return_date',
        'returned_by',
        'notes',
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function lendingDetails(): HasMany
    {
        return $this->hasMany(LendingDetail::class);
    }
    public function returnedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'returned_by');
    }
}
