<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;

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
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Product Name", "name")
                ->sortable(),
        ];
    }
}
