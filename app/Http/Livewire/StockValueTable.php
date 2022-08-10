<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stock;

class StockValueTable extends DataTableComponent
{
    protected $model = Stock::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->footer(function ($rows) {
                    return 'Total';
                }),
            Column::make("Product Name", "product.name")
                ->sortable(),
            Column::make("Batch No", "batch_number")
                ->sortable(),
            Column::make("Expiry date", "expiry_date")
                ->sortable(),
            Column::make("Purchase date", "purchase_date")
                ->sortable(),
            Column::make("Qty", "available_quantity")
                ->sortable(),
            Column::make("Total Cost", "purchase_price")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->purchase_price * $row->available_quantity
                )
                ->footer(function ($rows) {
                    $sum = 0;
                    foreach ($rows as $row) {
                        $sum += $row->purchase_price * $row->available_quantity;
                    }
                    return $sum;
                }),
            Column::make("Total Price", "selling_price")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->selling_price * $row->available_quantity
                )
                ->footer(function ($rows) {
                    $sum = 0;
                    foreach ($rows as $row) {
                        $sum += $row->selling_price * $row->available_quantity;
                    }
                    return $sum;
                }),
            Column::make("Net", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => ($row->selling_price * $row->available_quantity) - ($row->purchase_price * $row->available_quantity)
                )
                ->footer(function ($rows) {
                    $sum = 0;
                    foreach ($rows as $row) {
                        $sum += ($row->selling_price * $row->available_quantity) - ($row->purchase_price * $row->available_quantity);
                    }
                    return $sum;
                }),
        ];
    }
}
