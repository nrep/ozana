<?php

namespace App\Http\Livewire\Order\Create;

use App\Models\OrderItem;
use App\Models\Stock;
use Livewire\Component;

class Item extends Component
{
    public $itemIndex;
    public $stock_id;
    public $unit_price;
    public $available_quantity;
    public $order_quantity;
    public $price;

    // Add the save event listener to the component.
    protected $listeners = [
        'saved' => 'save',
    ];

    public function render()
    {
        return view('livewire.order.create.item');
    }

    public function updated($field)
    {
        if ($field == "stock_id") {
            $stockItem = Stock::find($this->stock_id);

            $this->unit_price = $stockItem->selling_price;
            $this->available_quantity = $stockItem->available_quantity;
        } else if ($field == "order_quantity") {
            $this->validate([
                'order_quantity' => 'required|numeric|min:1|max:'.$this->available_quantity,
            ]);
            $this->price = $this->unit_price * $this->order_quantity;
        } else if ($field == "unit_price") {
            if ($this->order_quantity > 0) {
                $this->price = $this->unit_price * $this->order_quantity;
            }
        }
    }

    public function save($orderId)
    {
        $orderItem = new OrderItem;

        $orderItem->order_id = $orderId;
        $orderItem->stock_id = $this->stock_id;
        $orderItem->quantity = $this->order_quantity;
        $orderItem->sold_at = $this->unit_price;
        $orderItem->user_id = auth()->user()->id;

        $orderItem->save();

        Stock::find($this->stock_id)->decrement('available_quantity', $this->order_quantity);
        Stock::find($this->stock_id)->increment('sold_quantity', $this->order_quantity);

        $this->emitUp('item_saved', $orderId);
    }
}
