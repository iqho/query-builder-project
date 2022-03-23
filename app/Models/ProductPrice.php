<?php

namespace App\Models;

use App\Models\PriceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'price_type_id', 'price', 'active_date'];

    public function priceType()
    {
        return $this->belongsTo(PriceType::class);
    }
}
