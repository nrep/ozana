<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stock;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Illuminate\Database\Eloquent\Builder;

class PurchasesAndExpensesTable extends DataTableComponent
{
    // protected $model = Stock::class;
    protected $queryString = ['table'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown();
    }

    public function builder(): Builder
    {
        $query = Stock::query();

        if (isset($this->table["filters"]["since"]) && isset($this->table["filters"]["until"])) {
            $query->where('purchase_date', '>=', $this->table["filters"]["since"])
                ->where('purchase_date', '<=', $this->table["filters"]["until"]);
        }
        return $query;
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
                ->sortable()
                ->searchable(),
            Column::make("Supplier", "supplier")
                ->sortable()
                ->searchable(),
            Column::make("Batch No", "batch_number")
                ->sortable()
                ->searchable(),
            Column::make("Purchase date", "purchase_date")
                ->sortable(),
            Column::make("Quantity", "purchased_quantity")
                ->sortable()
                ->searchable(),
            Column::make("Unit Cost", "purchase_price")
                ->sortable()
                ->searchable(),
            Column::make("Total Cost", "purchase_price")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $row->purchase_price * $row->purchased_quantity
                )
                ->footer(function ($rows) {
                    return $rows->sum('total_cost');
                }),
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Product Name')
                ->config([
                    'placeholder' => 'Product Name',
                ])
                ->filter(function ($builder, string $value) {
                    $builder->where('products.name', 'like', '%' . $value . '%');
                }),
            /* DateFilter::make('Since')
                ->setFilterPillTitle('Since'),
            DateFilter::make('Until')
                ->setFilterPillTitle('Until') */
        ];
    }
}
