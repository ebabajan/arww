<?php 

namespace App\Models;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profit extends Model
{
    use HasFactory;

    protected $casts = [
        'rate_time' => 'timestamp',
        'converted' => 'decimal:4',
        'profit' => 'decimal:2',
        'collection_id' => 'integer',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function collector()
    {
        return $this->hasOneThrough(
            Collector::class,
            Collection::class,
            'id', 
            'id', 
            'collection_id', 
            'collector_id' 
        );
    }

    public function supplierRate()
    {
        return $this->hasOneThrough(
            Supplier::class,
            Supply::class,
            'id', 
            'id', 
            'collection_id', 
            'supplier_id' 
        )->select('rate');
    }

    public function supply()
    {
        return $this->hasOneThrough(
            Supply::class,
            Collection::class,
            'id', 
            'id', 
            'collection_id', 
            'supply_id' 
        );
    }
    public function profit($record)
    {
        $record = $record->load(['collector', 'supplierRate', 'supply', 'collection']);

        $collectorRate = $record->collector->rate;
        $supplyRate = $record->supplierRate->rate;
        $amount = $record->collection->amount_collected;
        $exchange = $record->supply->ex_rate;
        $converted = $record->converted;

        // Calculate currentPayable with rounding
        $currentPayable = round(($amount - ($amount * $supplyRate / 100)) * $exchange, 4);

        // Calculate collectorCut with rounding
        $collectorCut = round($amount * ($collectorRate / 100), 2);

        // Calculate profit with rounding
        $profit = round($amount - ($currentPayable / $converted) - $collectorCut - $record->collection->overheads, 2);

        $record->profit = $profit;
        $record->save();
    }
}
