<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'amount_collected' => 'integer',
        'hawala_amount' => 'integer',
        'pickup_time' => 'timestamp',
        'amount_to_pay' => 'decimal:2',
        'overheads' => 'decimal:2',
        'supply_id' => 'integer',
        'collector_id' => 'integer',
    ];

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Collector::class);
    }

    public function profits()
    {
        return $this->hasMany(Profit::class);
    }

    public function collectionPayabaleUSD()
    {
        
    }
}
