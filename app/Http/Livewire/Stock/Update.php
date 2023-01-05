<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use App\Models\Stock;
use Livewire\Component;

class Update extends Component
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

    public $stockItem;

    public function mount(Stock $stockItem)
    {
        $this->stockItem = $stockItem;
        $this->product = $this->stockItem->product_id;
        $this->supplier = $this->stockItem->supplier;
        $this->batch_number = $this->stockItem->batch_number;
        $this->quantity = $this->stockItem->purchased_quantity;
        $this->cost = $this->stockItem->purchase_price;
        $this->price = $this->stockItem->selling_price;
        $this->expiry_date = $this->stockItem->expiry_date;
        $this->purchase_date = $this->stockItem->purchase_date;
    }

    public function render()
    {
        return view('livewire.stock.update', [
            "products" => Product::all()
        ]);
    }

    public function save()
    {
        $stock = Stock::find($this->stockItem->id);

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
        // $stock->purchased_quantity = $this->quantity;
        // $stock->sold_quantity = 0;
        // $stock->available_quantity = $this->quantity;
        $stock->purchase_price = $this->cost;
        $stock->selling_price = $this->price;
        $stock->expiry_date = $this->expiry_date;
        $stock->purchase_date = $this->purchase_date;
        $stock->user_id = auth()->user()->id;

        $stock->save();

        $this->showSavedAlert = true;
    }
}
