<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stock;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class StockTable extends DataTableComponent
{
    protected $model = Stock::class;
    public $user;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayout('slide-down');
        $this->setColumnSelectDisabled();

        $this->user = auth()->user();

        if ($this->user->can('create stock items')) {
            $this->setConfigurableAreas([
                'toolbar-right-end' => [
                    'new-button', [
                        'title' => 'Create Stock Entry',
                        'link' => 'stock.create',
                    ],
                ],
            ]);
        }
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Product Name')
                ->config([
                    'placeholder' => 'Search Product',
                ])
                ->filter(function ($builder, string $value) {
                    $builder->where('products.name', 'like', '%' . $value . '%');
                }),
            NumberFilter::make('Price')
                ->config([
                    'min' => 0,
                ])
                ->filter(function ($builder, string $value) {
                    $builder->where('selling_price', '>=', $value);
                }),
            DateFilter::make('Expiry Date')
                ->setFilterPillTitle('Expiry Date')
                ->filter(function ($builder, $value) {
                    $builder->where('expiry_date', '<=', $value);
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("NO", "id")
                ->sortable(),
            Column::make("Product Name", "product.name")
                ->sortable()
                ->searchable(),
            /* Column::make("Supplier", "supplier")
                ->sortable()
                ->searchable(), */
            Column::make("Batch no", "batch_number")
                ->sortable()
                ->searchable(),
            /* Column::make("Purchased quantity", "purchased_quantity")
                ->sortable(),
            Column::make("Sold quantity", "sold_quantity")
                ->sortable(), */
            Column::make("Quantity", "available_quantity")
                ->sortable(),
            Column::make("Cost", "purchase_price")
                ->sortable(),
            Column::make("Price", "selling_price")
                ->sortable(),
            Column::make("Expiry date", "expiry_date")
                ->sortable(),
            /* Column::make("Purchase date", "purchase_date")
                ->sortable(), */
        ];
    }
}
