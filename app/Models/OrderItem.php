<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'stock_id',
        'quantity',
        'user_id',
        'sold_at'
    ];

    // Get the stock that the order item is for.
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }

    // Get the order that the order item is for.
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Get the selling price of the stock that the order item is for.
    public function getSellingPriceAttribute()
    {
        return $this->sold_at;
    }

    // Calculate total price of the order item.
    public function getTotalPriceAttribute()
    {
        return $this->sold_at * $this->quantity;
    }
}
