<?php

namespace App\Livewire\Front\Catalog;

use App\Models\Front\Catalog\Auction\Auction;
use Livewire\Component;
use Livewire\WithPagination;

/**
 *
 */
class AuctionList extends Component
{

    use WithPagination;

    /**
     * @var string
     */
    public $group = '';

    /**
     * @var array
     */
    public $ids = [];


    /**
     * @return void
     */
    public function mount()
    {
        if ( ! empty($this->ids)) {

        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function render()
    {
        return view('livewire.front.catalog.auction-list', [
            'auctions' => $this->resolveAuctions()
        ]);
    }


    /**
     * @return mixed
     */
    private function resolveAuctions()
    {
        $auctions = Auction::query()->active();

        if ( ! empty($this->ids)) {
            $auctions = $auctions->whereIn('id', $this->ids);
        }

        return $auctions->paginate(20);
    }


    /**
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.pagination.bootstrap-livewire';
    }
}
