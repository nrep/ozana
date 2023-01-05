<?php

namespace App\Http\Livewire\Order\Update;

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

    protected $listeners = [
        'item_saved' => 'handleRedirections',
    ];

    public $savedItems = 0;
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;

        $this->date = $this->order->date;
        $this->name = $this->order->customer_name;
        $this->age = $this->order->customer_age;
        $this->sex = $this->order->customer_sex;
        $this->phone_number = $this->order->customer_phone_number;

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
        return view('livewire.order.update.form');
    }

    public function addOrderItem()
    {
        $this->orderItemsCount++;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'discount_id' => 'required',
            'date' => 'required',
        ]);

        $order = new Order;

        $order->customer_name = $this->name;
        $order->customer_age = $this->age;
        $order->customer_sex = $this->sex;
        $order->customer_phone_number = $this->phone_number;
        $order->date = $this->date;
        $order->user_id = auth()->user()->id;

        $order->save();

        $this->emit('saved', $order->id);

        $this->showSavedAlert = true;
    }

    public function handleRedirections($id) {
        $this->savedItems++;

        if ($this->savedItems == $this->orderItemsCount) {
            redirect()->route('orders.payments', $id);
        }
    }
}
