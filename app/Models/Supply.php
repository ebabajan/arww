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
        'ex_rate' => 'decimal:4',
        'date_supplied' => 'timestamp',
        'total_payable' => 'decimal:2',
        'supplier_id' => 'integer',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
