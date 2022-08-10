<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use App\Models\Stock;
use Livewire\Component;

class Form extends Component
{
    public $showSavedAlert = false;
    public $product;
    public $supplier;
    public $batch_number;
    public $quantity;
    public $cost;
    public $price;
    public $expiry_date;
    public $purchase_date;

    public function render()
    {
        return view('livewire.stock.form', [
            "products" => Product::all()
        ]);
    }

    public function save()
    {
        $stock = new Stock;

        if ((int)$this->product == 0) {
            $product = Product::create([
                "name" => $this->product,
                "user_id" => auth()->user()->id
            ]);

            $this->product = $product->id;
        }

        $stock->product_id = $this->product;
        $stock->supplier = $this->supplier;
        $stock->batch_number = $this->batch_number;
        $stock->purchased_quantity = $this->quantity;
        $stock->sold_quantity = 0;
        $stock->available_quantity = $this->quantity;
        $stock->purchase_price = $this->cost;
        $stock->selling_price = $this->price;
        $stock->expiry_date = $this->expiry_date;
        $stock->purchase_date = $this->purchase_date;
        $stock->user_id = auth()->user()->id;

        $stock->save();

        $this->showSavedAlert = true;
    }
}
