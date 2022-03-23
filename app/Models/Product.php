<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'description', 'image', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class)->Orderby('id', 'ASC');
    }

    public function retailPrice() {
       return $this->productPrices()->where('price_type_id', 1)->first();
    }

    public function wholeSalePrice() {
        return $this->productPrices()->where('price_type_id', 2)->first();
     }
}
