<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collector extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'rate' => 'decimal:2',
    ];

    public function collection(): HasMany
    {
        return $this->hasMany(Collection::class);
    }
}
