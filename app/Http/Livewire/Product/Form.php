<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Form extends Component
{
    public $showSavedAlert = false;
    public $name;

    public function render()
    {
        return view('livewire.product.form');
    }

    public function save() {
        $product = new Product;

        $product->name = $this->name;
        $product->user_id = auth()->user()->id;

        $product->save();

        $this->showSavedAlert = true;
    }
}
