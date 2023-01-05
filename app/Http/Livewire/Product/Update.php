<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Update extends Component
{
    public $showSavedAlert = false;
    public $name;

    public $product;

    public function mount(Product $product) {
        $this->product = $product;
        $this->name = $this->product->name;
    }

    public function render()
    {
        return view('livewire.product.update');
    }

    public function save() {
        $product = Product::find($this->product->id);

        $product->name = $this->name;
        $product->user_id = auth()->user()->id;

        $product->save();

        $this->showSavedAlert = true;
    }
}
