<?php

namespace App\Http\Livewire\Order;

use App\Models\Insurance;
use App\Models\Order;
use Livewire\Component;

class Form extends Component
{
    public $showSavedAlert = false;
    public $orderItemsCount = 1;
    public $name;
    public $age;
    public $sex;
    public $insurance_id;
    public $date;
    public $insurances;
    public $discount_id;
    public $discounts;
    public $phone_number;

    public function mount()
    {
        $this->date = date("Y-m-d");
        $this->insurances = Insurance::all();

        if (count($this->insurances) == 1) {
            $this->insurance_id = $this->insurances[0]->id;
            $this->discounts = $this->insurances[0]->discounts;
        }

        if (count($this->discounts) == 1) {
            $this->discount_id = $this->discounts[0]->id;
        }
    }

    public function render()
    {
        return view('livewire.order.form');
    }

    public function addOrderItem()
    {
        $this->orderItemsCount++;
    }

    public function save()
    {
        $order = new Order;

        $order->customer_name = $this->name;
        $order->customer_age = $this->age;
        $order->customer_sex = $this->sex;
        $order->customer_phone_number = $this->phone_number;
        $order->date = $this->date;
        $order->user_id = auth()->user()->id;

        $order->save();

        dd($order);

        $this->emit('saved', $order->id);

        $this->showSavedAlert = true;

        redirect()->route('orders.payments', $order->id);
    }
}
