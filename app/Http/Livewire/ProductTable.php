<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;
    public $user;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->user = auth()->user();

        if ($this->user->can('create products')) {
            $this->setConfigurableAreas([
                'toolbar-right-end' => [
                    'new-button', [
                        'title' => 'Add Product',
                        'link' => 'products.create',
                    ],
                ],
            ]);
        }
    }

    public function columns(): array
    {
        $columns = [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Product Name", "name")
                ->sortable(),
        ];

        if ($this->user->can('create products')) {
            $columns[] = ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons(
                    [
                        LinkColumn::make('Edit')
                            ->title(fn ($row) => 'Update')
                            ->location(fn ($row) => route('products.edit', $row->id))
                            ->attributes(function ($row) {
                                return [
                                    'class' => 'btn btn-outline-primary text-right',
                                ];
                            }),
                    ],
                );
        }

        return $columns;
    }
}
