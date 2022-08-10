<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class Bill extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.order.bill');
    }
}
