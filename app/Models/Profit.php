<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profit extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'rate_time' => 'timestamp',
        'converted' => 'decimal:4',
        'profit' => 'decimal:2',
        'collection_id' => 'integer',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
