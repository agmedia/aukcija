<?php

namespace App\Livewire;

use App\Models\Back\Catalog\Auction\Auction;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

/**
 *
 */
class AuctionsTable extends DataTableComponent
{

    /**
     * @var string
     */
    protected $model = Auction::class;


    /**
     * @return void
     */
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }


    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Šifra", "sku")
                ->sortable()
                ->searchable(),
            Column::make("Grupa", "group")
                ->sortable(),
            Column::make("Naziv", "name")
                ->sortable()
                ->searchable(),
            Column::make("Trenutna cijena", "current_price")
                ->sortable(),
            BooleanColumn::make('Status', 'status')
                ->toggleable('changeStatus'),
            ButtonGroupColumn::make('Uredi')
                ->attributes(function($row) {
                    return [
                        'class' => 'btn btn-sm btn-alt-secondary',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Uredi')
                        ->title(fn($row) => 'Uredi')
                        ->location(fn($row) => route('auctions.edit', ['auction' => $row]))
                        ->attributes(function($row) {
                            return [
                                'class' => 'underline text-blue-500 hover:no-underline',
                            ];
                        }),
                ]),

        ];
    }


    /**
     * @param int $id
     *
     * @return void
     */
    public function changeStatus(int $id)
    {
        $item = $this->model::find($id);
        $item->status = !$item->status;

        $item->save();
    }
}
