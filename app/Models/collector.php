<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Collector extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
    ];

    public function collectionRates(): HasOne
    {
        return $this->hasOne(CollectionRate::class);
    }
}
