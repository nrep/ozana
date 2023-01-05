<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_sex',
        'customer_age',
        'customer_phone_number',
        'insurance_discount_id',
        'date',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Calculate the sum of cost of all order items.
    public function getTotalCostAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->stock->purchase_price * $item->quantity;
        });
    }

    // Calculate the sum of price of all items in the order.
    public function getTotalPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->selling_price * $item->quantity;
        });
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Calculate the sum of paid amounts from payments
    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('paid_amount');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($order) {
            // do the rest of the cleanup...
            $order->items()->each(function ($item) {
                Stock::find($item->stock_id)->increment('available_quantity', $item->quantity);
                Stock::find($item->stock_id)->decrement('sold_quantity', $item->quantity);
                $item->delete();
            });

            $order->payments()->each(function ($payment) {
                $payment->delete();
            });
        });
    }
}
