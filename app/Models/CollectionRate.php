<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionRate extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'rate' => 'decimal:2',
        'collector_id' => 'integer',
    ];

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Collector::class);
    }
}
