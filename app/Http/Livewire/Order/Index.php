<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.order.index');
    }

    public function deleteOrder($id)
    {
        Order::find($id)->delete();

        redirect()->route('orders.index');
    }
}
