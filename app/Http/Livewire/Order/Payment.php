<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class Payment extends Component
{
    public $showSavedAlert = false;
    public $order;
    public $total_price;
    public $payment_method = "Cash";
    public $paid_amount;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->total_price = $order->total_price;
        $this->paid_amount = $order->total_price;
    }

    public function render()
    {
        return view('livewire.order.payment');
    }

    public function save()
    {
        $this->validate([
            'payment_method' => 'required',
            'paid_amount' => 'required|numeric|min:1|max:'.$this->total_price,
        ]);

        $this->order->payments()->create([
            'payment_method' => $this->payment_method,
            'total_amount' => $this->total_price,
            'paid_amount' => $this->paid_amount,
            'user_id' => auth()->user()->id,
        ]);
        
        $this->showSavedAlert = true;

        redirect()->route('orders.bill', $this->order->id);
    }
}
