<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class OrderTable extends DataTableComponent
{
    // protected $model = Order::class;
    public $user;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFiltersStatus(true);
        $this->setFilterLayout('slide-down');
        $this->setColumnSelectDisabled();

        $this->user = auth()->user();

        if ($this->user->can('create orders')) {
            $this->setConfigurableAreas([
                'toolbar-right-end' => [
                    'new-button', [
                        'title' => 'Create Order',
                        'link' => 'orders.create',
                    ],
                ],
            ]);
        }
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Customer Name')
                ->config([
                    'placeholder' => 'Customer Name',
                ])
                ->filter(function ($builder, string $value) {
                    $builder->where('customer_name', 'like', '%' . $value . '%');
                }),
            DateFilter::make('Date')
                ->setFilterPillTitle('Date')
                ->filter(function ($builder, $value) {
                    $builder->whereDate('date', $value);
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Customer name", "customer_name")
                ->sortable()
                ->searchable(),
            Column::make("Date", "date")
                ->sortable(),
            Column::make("Total Amount", "id")
                ->format(
                    fn ($value, $row, Column $column) => $row->total_price
                ),
            Column::make("Paid Amount", "id")
                ->format(
                    fn ($value, $row, Column $column) => $row->paid_amount
                ),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons(
                    [
                        LinkColumn::make('View') // make() has no effect in this case but needs to be set anyway
                            ->title(fn ($row) => 'View')
                            ->location(fn ($row) => route('orders.bill', $row->id))
                            ->attributes(function ($row) {
                                return [
                                    'class' => 'btn btn-outline-primary',
                                ];
                            }),
                        /* LinkColumn::make('Update') // make() has no effect in this case but needs to be set anyway
                            ->title(fn ($row) => 'Update')
                            ->location(fn ($row) => route('orders.edit', $row->id))
                            ->attributes(function ($row) {
                                return [
                                    'class' => 'btn btn-outline-primary',
                                ];
                            }),
                            */
                        LinkColumn::make("Delete")
                            ->title(fn ($row) => 'Delete')
                            ->location(fn ($row) => "#")
                            ->attributes(function ($row) {
                                return [
                                    'class' => 'btn btn-outline-danger',
                                    'onclick' => 'deleteOrder(' . $row->id . ')'
                                ];
                            }), 
                    ],
                ),
        ];
    }

    public function builder(): Builder
    {
        if (auth()->user()->can('view purchases and expenses report')) {
            $orders = Order::query();
        } else {
            $orders = Order::query()
                ->where('date', date('Y-m-d'));
        }
        return $orders;
            /* ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('users.name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('users.email', 'like', '%' . $email . '%')); */
    }
}
