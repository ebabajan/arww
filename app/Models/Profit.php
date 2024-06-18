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

    public function collector()
    {
        return $this->hasOneThrough(
            Collector::class,
            Collection::class,
            'id', // Foreign key on Collection table...
            'id', // Foreign key on Collector table...
            'collection_id', // Local key on Profit table...
            'collector_id' // Local key on Collection table...
        );

    }

    public function supplierRate()
    {
        return $this->hasOneThrough(
            Supplier::class,
            Supply::class,
            'id', // Foreign key on Supply table...
            'id', // Foreign key on Supplier table...
            'collection_id', // Local key on Profit table...
            'supplier_id' // Local key on Supply table...
        )->select('rate');
    }

    public function supply()
    {
        return $this->hasOneThrough(
            Supply::class,
            Collection::class,
            'id', // Foreign key on Collection table...
            'id', // Foreign key on Supply table...
            'collection_id', // Local key on Profit table...
            'supply_id' // Local key on Collection table...
        );
    }

    public function profit()
    {
        $collectorRate = $this->collector->rate;
        $supplyRate = $this->supplierRate->rate;
        $amount = $this->collection->amount_collected;
        $exchange = $this->supply->ex_rate;

        $currentPayable = ($amount - ($amount * $supplyRate/100)) * $exchange; 

        $collectorCut = $collectorRate /100 * $amount;

        $profit = $amount - ($currentPayable/$this->converted) - $collectorCut - $this->collection->overheads;

        $this->profit = $profit;
        $this->save();
    }
}
