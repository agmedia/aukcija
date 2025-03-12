<?php

namespace App\Livewire\Front\Catalog;

use App\Models\Front\Catalog\Auction\Auction;
use Livewire\Component;
use Livewire\WithPagination;

class AuctionList extends Component
{
    use WithPagination;
    public $group = '';


    public function mount()
    {
        if ($this->group !== '') {

        }
    }

    public function render()
    {
        return view('livewire.front.catalog.auction-list', [
            'auctions' => $this->resolveAuctions()
        ]);
    }


    private function resolveAuctions()
    {
        //dd(Auction::query()->active()->paginate(20));
        return Auction::query()->active()->paginate(20);

        /*foreach ($auctions as $auction) {
            $this->auctions[] = [
                'id' => $auction->id,
                'title' => $auction->title,
            ];
        }*/
    }



    /**
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.pagination.bootstrap-livewire';
    }
}
