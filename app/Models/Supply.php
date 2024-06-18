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

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function totalSupply()
    {
        $amount = $this->amount;
    
        $supplierRate = $this->supplier->rate;
    
        $adjustedAmount = $amount - ($supplierRate / 100 * $amount);
    
        $totalPayable = $adjustedAmount * $this->ex_rate;
    
        $this->total_payable = $totalPayable;
    
        if ($this->balance) {
            $this->balance->update(['total_payable' => $totalPayable]);
        } else {
            // Create a new balance record if it doesn't exist
            $this->balance()->create(['total_payable' => $totalPayable, 'supply_id' => $this->id]);
        }

        $this->balance->save();
    
        $this->save();
    }
    
}
