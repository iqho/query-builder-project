<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{
    use HasFactory;

    protected $fillable = ['price_type'];

    public function priceType()
    {
        return $this->belongsTo(ProductPrice::class);
    }

}
