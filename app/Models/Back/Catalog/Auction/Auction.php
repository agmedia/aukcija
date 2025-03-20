<?php

namespace App\Models\Back\Catalog\Auction;

use App\Helpers\Helper;
use App\Helpers\AuctionHelper;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Bouncer;
use Illuminate\Validation\ValidationException;

class Auction extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'auctions';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var null
     */
    protected $old_auction = null;


    /**
     * @return Relation
     */
    public function images()
    {
        return $this->hasMany(AuctionImage::class, 'auction_id')->orderBy('sort_order');
    }


    /**
     * @return Relation
     */
    public function attributes()
    {
        return $this->hasMany(AuctionAttribute::class, 'auction_id')->with('attribute');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'auction_id')->with('user');
    }


    /**
     * @return string
     */
    public function imageName()
    {
        $from   = strrpos($this->image, '/') + 1;
        $length = strrpos($this->image, '-') - $from;

        return substr($this->image, $from, $length);
    }


    /**
     * Validate New Auction Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        // Validate the request.
        $request->validate([
            'name' => 'required'
        ]);

        // Set Auction Model request variable
        $this->setRequest($request);

        if ($this->isDuplicateSku()) {
            throw ValidationException::withMessages(['sku_dupl' => $this->request->sku . ' - Šifra već postoji...']);
        }

        return $this;
    }


    /**
     * Create and return new Auction Model.
     *
     * @return mixed
     */
    public function create()
    {
        $id = $this->insertGetId($this->getModelArray());

        if ($id) {
            $this->resolveAttributes($id);

            $auction = $this->find($id);

            $auction->update([
                'url'             => AuctionHelper::url($auction),
                'category_string' => '',//AuctionHelper::categoryString($auction),
                'special_lock'    => $this->resolveActionLock($id)
            ]);

            return $auction;
        }

        return false;
    }


    /**
     * Update and return new Auction Model.
     *
     * @return mixed
     */
    public function edit()
    {
        $updated = $this->update($this->getModelArray(false));

        if ($updated) {
            $this->resolveAttributes($this->id);

            $this->update([
                'url'             => AuctionHelper::url($this),
                'category_string' => '',//AuctionHelper::categoryString($this),
                'special_lock'    => $this->resolveActionLock($this->id, false)
            ]);

            return $this;
        }

        return false;
    }


    /**
     * @param bool $insert
     *
     * @return array
     */
    private function getModelArray(bool $insert = true): array
    {
        $current_price = isset($this->request->current_price) ? $this->request->current_price : 0;

        if ($insert) {
            $slug = $this->resolveSlug();

            if ( ! $current_price) {
                $current_price = isset($this->request->starting_price) ? $this->request->starting_price : 0;
            }
        } else {
            $this->old_auction = $this->setHistoryAuction();
            $slug              = $this->request->slug;
        }

        $min_increment = $this->resolveMinIncrement(isset($this->request->starting_price) ? $this->request->starting_price : '10');

        $response = [
            'sku'              => $this->request->sku,
            'ean'              => $this->request->ean,
            'group'            => $this->request->group ?: 'Top',
            'name'             => $this->request->name,
            'description'      => $this->cleanHTML($this->request->description),
            'meta_title'       => $this->request->meta_title ?: $this->request->name,
            'meta_description' => $this->request->meta_description,
            'slug'             => $slug,
            'url'             => '/',
            'starting_price'   => isset($this->request->starting_price) ? $this->request->starting_price : 0,
            'current_price'    => $current_price,
            'reserve_price'    => isset($this->request->reserve_price) ? $this->request->reserve_price : 0,
            'min_increment'    => $min_increment,
            'start_time'       => $this->request->start_time ? Carbon::make($this->request->start_time) : null,
            'end_time'         => $this->request->end_time ? Carbon::make($this->request->end_time) : null,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'active'           => (isset($this->request->active) and $this->request->active == 'on') ? 1 : 0,
            'tax_id'           => $this->request->tax_id ?: 1,
            'viewed'           => 0,
            'featured'         => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'sort_order'       => 0,
            'updated_at'       => Carbon::now()
        ];

        if ($insert) {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }


    /**
     * @return array
     */
    public function getRelationsData(): array
    {
        return [
            'categories' => (new Category())->getList(false),
            'images'     => AuctionImage::getAdminList($this->id),
            'letters'    => Settings::get('auction', 'letter_styles'),
            'conditions' => Settings::get('auction', 'condition_styles'),
            'bindings'   => Settings::get('auction', 'binding_styles'),
            'taxes'      => Settings::get('tax', 'list')
        ];
    }


    /**
     * @param Auction $auction
     *
     * @return mixed
     */
    public function storeImages(Auction $auction)
    {
        return (new AuctionImage())->store($auction, $this->request);
    }


    /**
     * @param string $type
     *
     * @return mixed
     */
    public function addHistoryData(string $type)
    {
        $new = $this->setHistoryAuction();

        $history = new AuctionHistory($new, $this->old_auction);

        return $history->addData($type);
    }


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = (new Auction())->newQuery();

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('sku', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('polica', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('year', 'like', '' . $request->input('search') . '');
        }

        if ($request->has('status')) {
            if ($request->input('status') == 'active') {
                $query->where('status', 1);
            }
            if ($request->input('status') == 'inactive') {
                $query->where('status', 0);
            }
        }

        if ($request->has('sort')) {
            if ($request->input('sort') == 'new') {
                $query->orderBy('created_at', 'desc');
            }
            if ($request->input('sort') == 'old') {
                $query->orderBy('created_at', 'asc');
            }
            if ($request->input('sort') == 'price_up') {
                $query->orderBy('price', 'asc');
            }
            if ($request->input('sort') == 'price_down') {
                $query->orderBy('price', 'desc');
            }
            if ($request->input('sort') == 'az') {
                $query->orderBy('name', 'asc');
            }
            if ($request->input('sort') == 'za') {
                $query->orderBy('name', 'desc');
            }
            if ($request->input('sort') == 'qty_up') {
                $query->orderBy('quantity', 'asc');
            }
            if ($request->input('sort') == 'qty_down') {
                $query->orderBy('quantity', 'desc');
            }
        } else {
            $query->orderBy('updated_at', 'desc');

        }

        return $query;
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param $request
     *
     * @return void
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }


    /**
     * @return mixed
     */
    private function setHistoryAuction()
    {
        $auction = $this->where('id', $this->id)->first();

        $response             = $auction->toArray();
        $response['category'] = [];
        $response['subcategory'] = [];
        $response['images']      = $auction->images()->get()->toArray();

        return $response;
    }


    /**
     * @param null $description
     *
     * @return string
     */
    private function cleanHTML($description = null): string
    {
        $clean = preg_replace('/ style=("|\')(.*?)("|\')/', '', $description ?: '');

        return preg_replace('/ face=("|\')(.*?)("|\')/', '', $clean);
    }


    /**
     * @param int $auction_id
     *
     * @return bool
     */
    private function resolveAttributes(int $auction_id): bool
    {
        if ( ! empty($this->request->product_attributes) && is_array($this->request->product_attributes)) {
            AuctionAttribute::storeData($this->request->product_attributes, $auction_id);

            return true;
        }

        return false;
    }


    /**
     * @param int  $auction_id
     * @param bool $insert
     *
     * @return int
     */
    private function resolveActionLock(int $auction_id, bool $insert = true): int
    {
        if ($insert) {
            if ($this->request->special) {
                return $this->createActionFromAuction($auction_id);
            }
        }

        $auction = $this->newQuery()->find($auction_id);

        if ($auction->special) {
            if ( ! $auction->action_id) {
                return $this->createActionFromAuction($auction_id);
            }

            if ($auction->lock) {
                return 1;
            }
        }

        return 0;
    }


    /**
     * @param int $auction_id
     *
     * @return int
     */
    private function createActionFromAuction(int $auction_id): int
    {
        $action_id = Action::createFromAuction($auction_id, $this->request);

        $this->newQuery()->where('id', $auction_id)
             ->update(['action_id' => $action_id]);

        return 1;
    }


    /**
     * @param string       $target
     * @param Request|null $request
     *
     * @return string
     */
    private function resolveSlug(string $target = 'insert', Request $request = null): string
    {
        $slug = null;

        if ($request) {
            $this->request = $request;
        }

        if ($target == 'update') {
            $auction = Auction::where('id', $this->id)->first();

            if ($auction) {
                $slug = $auction->slug;
            }
        }

        $slug  = $slug ?: Str::slug($this->request->name);
        $exist = $this->where('slug', $slug)->count();

        $cat_exist = Category::where('slug', $slug)->count();

        if (($cat_exist || $exist > 1) && $target == 'update') {
            return $slug . '-' . time();
        }

        if (($cat_exist || $exist) && $target == 'insert') {
            return $slug . '-' . time();
        }

        return $slug;
    }


    /**
     * @param string $price
     *
     * @return int|float
     */
    private function resolveMinIncrement(string $price): int|float
    {
        $increases = config('settings.bid_increase');

        foreach ($increases as $value) {
            if ($value['from'] <= $price && $value['to'] > $price) {
                return $value['amount'];
            }
        }

        return 5;
    }


    /**
     * @return bool
     */
    private function isDuplicateSku(): bool
    {
        $exist = $this->where('sku', $this->request->sku)->first();

        if (isset($this->id) && $exist && $exist->id != $this->id) {
            return true;
        }

        return false;
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', 0);
    }





    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLast(Builder $query, $count = 12): Builder
    {
        return $query->where('status', 1)->orderBy('created_at', 'desc')->limit($count);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeCreated($query, $count = 9)
    {
        return $query->where('status', 1)->orderBy('created_at', 'desc')->limit($count);
    }





    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePopular(Builder $query, $count = 12): Builder
    {
        return $query->where('featured', 1)->orderBy('viewed', 'desc')->limit($count);
    }

}
