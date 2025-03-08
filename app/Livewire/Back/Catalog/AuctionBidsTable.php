<?php

namespace App\Livewire\Back\Catalog;

use Livewire\Component;
use Livewire\WithPagination;

class AuctionBidsTable extends Component
{
    use WithPagination;
    
    public $auction = null;
    public $bids = [];
    
    
    public function render()
    {
        //dd($this->bids);
        return view('livewire.back.catalog.auction-bids-table');
    }
    
    
    /**
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.pagination.bootstrap-livewire';
    }
}
