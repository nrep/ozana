<?php

namespace App\Http\Livewire\Stock;

use App\Models\Stock;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.stock.index');
    }

    public function deleteStockItem($id)
    {
        Stock::find($id)->delete();

        redirect()->route('stock.index');
    }
}
