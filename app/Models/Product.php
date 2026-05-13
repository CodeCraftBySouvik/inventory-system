<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = [
       'product_name', 'product_code', 'price'
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class,'product_id');
    }
}
