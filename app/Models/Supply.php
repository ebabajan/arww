<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Stmt\Return_;

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
        return $totalPayable;
    }

    public function setPayable()
    {
        $this->total_payable = $this->totalSupply();
        $this->save();
    }

    public function updateBalance()
    {
        $totalPayable = $this->totalSupply();

        if($this->id && $this->total_payable)
        {
            // $this->balance->supply_id = $this->id;
            // $this->balance->total_payable = $this->total_payable;
            $this->balance()->create( [
                'supply_id' => $this->id, 
                'total_payable' => $this->total_payable
            ]);
            $this->balance->save();
            return;
        }
        $this->balance->save();
    }
}
