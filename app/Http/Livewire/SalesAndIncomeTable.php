<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\OrderItem;
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
                ->sortable()
                ->searchable(),
            Column::make("Date", "order.date")
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->sortable()
                ->searchable(),
            Column::make("Unit Price", "stock.selling_price")
                ->sortable()
                ->searchable(),
            Column::make("Total Price", "stock.selling_price")
                ->sortable()
                ->format(function ($value, $row, Column $column) {
                    return $value * $row->quantity;
                })
                ->searchable()
                ->footer(function ($rows) {
                    $sum = 0;
                    foreach ($rows as $row) {
                        $sum += $row["stock.selling_price"] * $row->quantity;
                    }
                    return $sum;
                }),
        ];
    }

    public function builder(): Builder
    {
        return OrderItem::query();
            /* ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('users.name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('users.email', 'like', '%' . $email . '%')); */
    }
}
