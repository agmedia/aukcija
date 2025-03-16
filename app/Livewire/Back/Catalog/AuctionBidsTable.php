<?php

namespace App\Livewire\Back\Catalog;

use App\Models\Back\Catalog\Auction\AuctionBid;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 *
 */
class AuctionBidsTable extends Component
{

    use WithPagination;

    /**
     * @var null
     */
    public $auction = null;

    /**
     * @var array
     */
    public $bids = [];

    /**
     * @var null[]
     */
    public $new = [
        'amount'  => null,
        'user_id' => null,
    ];

    /**
     * @var
     */
    public $users;

    /**
     * @var
     */
    public $show_new;

    public $showModal = false;


    /**
     * @return void
     */
    public function mount()
    {
        $this->users = User::query()
                           ->whereHas('details', function (Builder $query) {
                               $query->where('can_bid', 1)->where('status', 1);
                           })
                           ->pluck('name', 'id')
                           ->toArray();
    }


    /**
     * @param int $bid_id
     *
     * @return void
     */
    public function deleteBid(int $bid_id)
    {
        AuctionBid::query()->findOrFail($bid_id)->delete();

        $this->render();
    }


    /**
     * @return void
     */
    public function saveNewBid()
    {
        if ( ! empty($this->new['amount']) && ! empty($this->new['user_id'])) {
            $bid = AuctionBid::query()->create([
                'auction_id' => $this->auction->id,
                'user_id'    => $this->new['user_id'],
                'amount'     => $this->new['amount'],
            ]);

            if ($bid) {
                $this->new = [
                    'amount'  => null,
                    'user_id' => null,
                ];
            }

            $this->showNewBidWindow();
        }
    }


    /**
     * @return void
     */
    public function showNewBidWindow()
    {
        $this->show_new = ! $this->show_new;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function render()
    {
        if ($this->auction) {
            $this->bids = $this->auction->bids()->orderBy('created_at', 'desc')->get()->toArray();
        }

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
