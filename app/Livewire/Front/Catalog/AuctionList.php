<?php

namespace App\Livewire\Front\Catalog;

use App\Models\Front\Catalog\Auction\Auction;
use App\Models\Front\Catalog\Group;
use Illuminate\Support\Str;
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
    public $groups = [];

    /**
     * @var array
     */
    public $ids = [];

    /**
     * @var string
     */
    #[Url(except: '')]
    public string $sort = '';

    /**
     * @var string[]
     */
    protected $queryString = ['sort'];


    /**
     * @return void
     */
    public function mount()
    {
        $this->groups = Group::query()->where('status', 1)->get();
    }


    /**
     * @return void
     */
    public function selectGroup()
    {
        $this->redirectRoute('catalog.route', ['group' => $this->group]);
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

        if ($this->group == Str::slug(config('settings.archive_auctions_path'))) {
            $auctions = $auctions->where('end_time', '<=', now());
        }

        if ($this->group != '') {
            $group = Group::query()->where('group', $this->group)->first();

            if ($group) {
                $auctions = $auctions->where('group', $group->group_title);
            }
        }

        if ( ! empty($this->ids)) {
            $auctions = $auctions->whereIn('id', $this->ids);
        }

        if ($this->sort != '') {
            $sort     = explode('-', $this->sort);
            $auctions = $auctions->orderBy($sort[0], $sort[1]);
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
