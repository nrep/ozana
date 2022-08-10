<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Order;

class IncomeVsExpensesTable extends DataTableComponent
{
    protected $model = Order::class;

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
            Column::make("Bill No", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => substr(config('company.name'), 0, 3) . "-" . sprintf("%06d", $row->id)
                ),
            Column::make("Date", "date")
                ->sortable(),
            Column::make("Products Count", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => count($row->items)
                ),
            Column::make("Total Cost", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->total_cost
                )
                ->footer(function ($rows) {
                    return $rows->sum('total_cost');
                }),
            Column::make("Total Price", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->total_price
                )
                ->footer(function ($rows) {
                    return $rows->sum('total_price');
                }),
            Column::make("Paid Amount", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->paid_amount
                )
                ->footer(function ($rows) {
                    return $rows->sum('paid_amount');
                }),
            Column::make("Profit", "id")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->paid_amount - $row->total_cost
                )
                ->footer(function ($rows) {
                    return $rows->sum('paid_amount') - $rows->sum('total_cost');
                }),
        ];
    }
}
