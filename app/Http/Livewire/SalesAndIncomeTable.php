<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;

class SalesAndIncomeTable extends DataTableComponent
{
    // protected $model = OrderItem::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEagerLoadAllRelationsEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->footer(function ($rows) {
                    return 'Total';
                }),
            Column::make("Bill No", "order_id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => substr(config('company.name'), 0, 3) . "-" . sprintf("%06d", $row->order_id)
                )
                ->searchable(),
            Column::make("Product Name", "stock.product.name")
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy(Stock::select('products.name')->whereColumn('stocks.id', 'stock_id'), $direction)
                )
                ->searchable(),
            Column::make("Date", "order.date")
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy(Order::select('date')->whereColumn('orders.id', 'order_id'), $direction)
                ),
            Column::make("Quantity", "quantity")
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy('quantity', $direction)
                )
                ->searchable(),
            Column::make("Unit Price", "sold_at")
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy('sold_at', $direction)
                )
                ->searchable(),
            Column::make("Total Price", "sold_at")
                ->format(function ($value, $row, Column $column) {
                    return $value * $row->quantity;
                })
                ->searchable()
                ->footer(function ($rows) {
                    $sum = 0;
                    foreach ($rows as $row) {
                        $sum += $row["sold_at"] * $row->quantity;
                    }
                    return $sum;
                }),
        ];
    }

    public function builder(): Builder
    {
        if (auth()->user()->can('view sales and income report')) {
            $orderItems = OrderItem::query();
        } else {
            $orderItems = OrderItem::query()
                ->whereHas('order', function ($query) {
                    $query->where('date', date('Y-m-d'));
                });
        }
        return $orderItems;
            /* ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('users.name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('users.email', 'like', '%' . $email . '%')); */
    }
}
