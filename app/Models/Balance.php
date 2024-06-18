<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'total_payable' => 'decimal:2',
        'amount_paid_1' => 'decimal:2',
        'amount_paid_2' => 'decimal:2',
        'amount_paid_3' => 'decimal:2',
        'amount_paid_4' => 'decimal:2',
        'amount_paid_5' => 'decimal:2',
        'remaining' => 'decimal:2',
        'supply_id' => 'integer',
    ];

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }

    public function updateRemaining()
    {
        $this->remaining = $this->total_payable 
            - $this->amount_paid_1 
            - $this->amount_paid_2 
            - $this->amount_paid_3 
            - $this->amount_paid_4 
            - $this->amount_paid_5;

        $this->save();
    }
}
