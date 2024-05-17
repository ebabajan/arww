<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supply extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'amount' => 'integer',
        'rate' => 'decimal:2',
        'date_supplied' => 'timestamp',
        'day_rate' => 'decimal:4',
        'supplier_id' => 'integer',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
