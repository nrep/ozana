<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'supplier',
        'batch_number',
        'purchased_quantity',
        'sold_quantity',
        'available_quantity',
        'purchase_price',
        'selling_price',
        'expiry_date',
        'purchase_date',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Calcute the total cost of the stock
    public function getTotalCostAttribute()
    {
        return $this->purchase_price * $this->purchased_quantity;
    }

    // Calculate the total price of the stock
    public function getTotalPriceAttribute()
    {
        return $this->selling_price * $this->available_quantity;
    }
}
