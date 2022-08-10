<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;

class ExpiryTable extends DataTableComponent
{
    // protected $model = Stock::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Product Name", "product.name")
                ->sortable(),
            Column::make("Supplier", "supplier")
                ->sortable(),
            Column::make("Batch No", "batch_number")
                ->sortable(),
            Column::make("Purchased quantity", "purchased_quantity")
                ->sortable(),
            Column::make("Sold quantity", "sold_quantity")
                ->sortable(),
            Column::make("Available quantity", "available_quantity")
                ->sortable(),
            Column::make("Purchase price", "purchase_price")
                ->sortable(),
            Column::make("Selling price", "selling_price")
                ->sortable(),
            Column::make("Expiry date", "expiry_date")
                ->sortable(),
            Column::make("Purchase date", "purchase_date")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        // Calculate the date after a month
        $date = date('Y-m-d', strtotime('+1 month'));
        return Stock::query()
            ->where('expiry_date', '<=', $date);
            /* ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('users.name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('users.email', 'like', '%' . $email . '%')); */
    }
}
