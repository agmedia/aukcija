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
            'name'     => 'required',
            'sku'      => 'required',
            'price'    => 'required',
            'category' => 'required'
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
            $this->resolveCategories($id);

            $auction = $this->find($id);

            $auction->update([
                'url'             => AuctionHelper::url($auction),
                'category_string' => AuctionHelper::categoryString($auction),
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
            $this->resolveCategories($this->id);

            $this->update([
                'url'             => AuctionHelper::url($this),
                'category_string' => AuctionHelper::categoryString($this),
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
        if ($insert) {
            $slug = $this->resolveSlug();
        } else {
            $this->old_auction = $this->setHistoryAuction();
            $slug              = $this->request->slug;
        }

        $response = [
            'author_id'        => $this->request->author_id ?: 6,
            'publisher_id'     => $this->request->publisher_id ?: 2,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'polica'           => $this->request->polica,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $slug,
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'quantity'         => $this->request->quantity ?: 0,
            'decrease'         => (isset($this->request->decrease) and $this->request->decrease == 'on') ? 0 : 1,
            'tax_id'           => $this->request->tax_id ?: 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'special_lock'     => 0,
            'meta_title'       => $this->request->meta_title ?: $this->request->name/* . '-' . ($author ? '-' . $author->title : '')*/,
            'meta_description' => $this->request->meta_description,
            'pages'            => $this->request->pages,
            'dimensions'       => $this->request->dimensions,
            'origin'           => $this->request->origin,
            'letter'           => $this->request->letter,
            'condition'        => $this->request->condition,
            'binding'          => $this->request->binding,
            'year'             => $this->request->year,
            'viewed'           => 0,
            'sort_order'       => 0,
            'push'             => 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
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
     * @return $this
     */
    public function checkSettings()
    {
        Settings::setAuction('letter_styles', $this->request->letter);
        Settings::setAuction('condition_styles', $this->request->condition);
        Settings::setAuction('binding_styles', $this->request->binding);

        return $this;
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

        if ($auction->category()) {
            $response['category'] = $auction->category()->toArray();
        }

        $response['subcategory'] = $auction->subcategory() ? $auction->subcategory()->toArray() : [];
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
    private function resolveCategories(int $auction_id): bool
    {
        if ( ! empty($this->request->category) && is_array($this->request->category)) {
            AuctionCategory::storeData($this->request->category, $auction_id);

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

}
