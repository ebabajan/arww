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
        'amount' => 'integer',
        'hawala_amount' => 'integer',
        'pickup_time' => 'timestamp',
        'rate_time' => 'timestamp',
        'ex_rate_supplier' => 'decimal:2',
        'supplier_rate' => 'decimal:2',
        'amount_to_pay' => 'decimal:2',
        'exchange_rate' => 'decimal:2',
        'profit' => 'decimal:2',
        'collector_id' => 'integer',
    ];

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Collector::class);
    }

    public function calculateCollectorFee()
    {
        $amount = $this->amount ?? 0;
        $hawalaAmount = $this->hawala_amount ?? 0;
        $rate = $this->collector->rate ?? 1;

        $this->colFee = $amount - $hawalaAmount;
        return ($rate/100 * $this->colFee) ;
    }

    public function profit()
    {
        $collectorFee = $this->calculateCollectorFee();
        $amountToPay = $this->amount_to_pay ?? 0;
        $exchangeRate = $this->exchange_rate ?? 1;
        $profit = $this->amount - $this->overheads - $this->hawala_amount - $collectorFee - ($amountToPay / $exchangeRate);
        return $profit;
    }



    public function calculateAmountToPay()
    {
        $amount = $this->amount ?? 0;
        $hawalaAmount = $this->hawala_amount ?? 0;
        $supplierRate = $this->supplier_rate ?? 0;
        $exRateSupplier = $this->ex_rate_supplier ?? 1;

        $netAmount = $amount - $hawalaAmount;
        return ($netAmount - ($netAmount * $supplierRate / 100)) * $exRateSupplier;
    }
    
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->amount_to_pay = $model->calculateAmountToPay();
        });
    }
}
