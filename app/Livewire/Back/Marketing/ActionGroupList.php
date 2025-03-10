<?php

namespace App\Livewire\Back\Marketing;

use App\Models\Back\Catalog\Auction\Auction;
use App\Models\Back\Marketing\Blog;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ActionGroupList extends Component
{
    use WithPagination;

    /**
     * @var string[]
     */
    protected $listeners = ['groupUpdated' => 'groupSelected'];

    /**
     * @var string
     */
    public $search = '';

    /**
     * @var array
     */
    public $search_results = [];

    /**
     * @var string
     */
    public $group = '';

    /**
     * @var Collection
     */
    public $list = [];

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var int
     */
    public $dropdown_limit = 5;

    /**
     * @var bool
     */
    public $disabled = false;


    /**
     * @return void
     */
    public function mount()
    {
        if ( ! empty($this->list)) {
            $ids = $this->list;
            $this->list = [];

            foreach ($ids as $id) {
                $this->addItem(intval($id));
            }
        }

        if ($this->group == 'all') {
            $this->title = 'Bez nakladnika';
        }

        $this->resolveTitle();
        $this->render();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        if ( ! empty($this->list)) {
            $this->dispatch('list_full');
        } else {
            $this->dispatch('list_empty');
        }

        return view('livewire.back.marketing.action-group-list', [
            'list' => $this->list,
            'group' => $this->group
        ]);
    }


    /**
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.pagination.bootstrap-livewire';
    }


    /**
     * @return void
     */
    public function resolveTitle(): void
    {
        switch ($this->group) {
            case 'auction':
                $this->title = 'Aukcije koje želite uključiti' . $this->requiredSymbol();
                break;
            case 'blog':
                $this->title = 'Novosti koje želite uključiti' . $this->requiredSymbol();
                break;
            /*case 'all':
                $this->title = 'Nakladnici koje želite isključiti <span class="font-weight-lighter text-xs font-italic">Opcionalno</span>';
                break;*/
            case 'total':
                $this->title = '';
                break;
        }
    }


    /**
     * @param string $value
     */
    public function updatingSearch(string $value)
    {
        $this->search = $value;
        $this->search_results = [];

        if ($this->search != '') {
            switch ($this->group) {
                case 'auction':
                    $this->search_results = Auction::where('name', 'like', '%' . $this->search . '%')->orWhere('sku', 'like', '%' . $this->search . '%')->limit($this->dropdown_limit)->get();
                    break;
                case 'single':
                    $this->search_results = Auction::where('name', 'like', '%' . $this->search . '%')->orWhere('sku', 'like', '%' . $this->search . '%')->limit($this->dropdown_limit)->get();
                    break;
                case 'blog':
                    $this->search_results = Blog::where('title', 'like', '%' . $this->search . '%')->limit($this->dropdown_limit)->get();
                    break;
                /*case 'all':
                    $this->search_results = Publisher::where('title', 'like', '%' . $this->search . '%')->limit($this->dropdown_limit)->get();
                    break;*/
            }
        }
    }


    /**
     * @param int $id
     */
    public function addItem(int $id)
    {
        $this->search = '';
        $this->search_results = [];

        if ($id) {
            switch ($this->group) {
                case 'auction':
                    $this->list[$id] = Auction::where('id', $id)->first();
                    break;
                case 'single':
                    $this->list[$id] = Auction::where('id', $id)->first();
                    $this->disabled = true;
                    break;
                case 'blog':
                    $this->list[$id] = Blog::where('id', $id)->first();
                    break;
                /*case 'all':
                    $this->list[$id] = Publisher::where('id', $id)->first();
                    break;*/
            }
        }
    }


    /**
     * @param int $id
     */
    public function removeItem(int $id)
    {
        if ($this->list[$id]) {
            unset($this->list[$id]);

            if ($this->group == 'single') {
                $this->disabled = false;
            }
        }
    }


    /**
     * @param string $group
     */
    public function groupSelected(string $group)
    {
        $this->group = $group;
        $this->resolveTitle();
    }


    /**
     * @return string
     */
    private function requiredSymbol(): string
    {
        return ' <span class="text-danger">*</span>';
    }
}
