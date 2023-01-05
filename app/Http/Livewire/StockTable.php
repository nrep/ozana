<?php

namespace App\Http\Livewire;

use App\Exports\StockExport;
use App\Models\Product;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stock;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class StockTable extends DataTableComponent
{
    // protected $model = Stock::class;
    public $user;

    public function builder(): Builder
    {
        return Stock::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayout('slide-down');
        $this->setColumnSelectDisabled();
        $this->setDefaultReorderSort('products.name', 'desc');

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
        $columns = [
            Column::make("NO", "id")
                ->sortable(),
            Column::make("Product Name", "product.name")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy(Product::select('name')->whereColumn('products.id', 'product_id'), $direction)
                )
                ->searchable(),
            /* Column::make("Supplier", "supplier")
                ->sortable()
                ->searchable(), */
            Column::make("Batch no", "batch_number")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('batch_number', $direction)
                )
                ->searchable(),
            Column::make("Purchased qty", "purchased_quantity")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('purchased_quantity', $direction)
                ),
            Column::make("Sold qty", "sold_quantity")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('sold_quantity', $direction)
                ),
            Column::make("Quantity", "available_quantity")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('available_quantity', $direction)
                ),
            Column::make("Cost", "purchase_price")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('purchase_price', $direction)
                ),
            Column::make("Price", "selling_price")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('selling_price', $direction)
                ),
            Column::make("Expiry date", "expiry_date")
                ->sortable(
                    fn (Builder $query, string $direction) => $query->orderBy('expiry_date', $direction)
                ),
            /* Column::make("Purchase date", "purchase_date")
                ->sortable(), */
        ];

        if ($this->user->can('edit stock items')) {
            $columns[] = ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons(
                    [
                        LinkColumn::make('Update') // make() has no effect in this case but needs to be set anyway
                            ->title(fn ($row) => 'Update')
                            ->location(fn ($row) => route('stock.edit', $row->id))
                            ->attributes(function ($row) {
                                return [
                                    'class' => 'btn btn-outline-primary',
                                ];
                            }),
                        LinkColumn::make("Delete")
                            ->title(fn ($row) => 'Delete')
                            ->location(fn ($row) => "#")
                            ->attributes(function ($row) {
                                return [
                                    'class' => 'btn btn-outline-danger',
                                    'onclick' => 'deleteStockItem(' . $row->id . ')'
                                ];
                            }),
                    ],
                );
        }

        return $columns;
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export Excel',
        ];
    }

    public function export()
    {
        $stockItems = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new StockExport($stockItems), 'Stock items as on '.date('Y-m-d h:i:s').'.xlsx');
    }
}
