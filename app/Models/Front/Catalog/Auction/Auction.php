<?php

namespace App\Models\Front\Catalog\Auction;

use App\Helpers\Helper;
use App\Models\Back\Catalog\Auction\AuctionBid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Auction extends Model
{

    /**
     * @var string
     */
    protected $table = 'auctions';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = [
        'base_price',
        'days_left'
    ];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param $value
     *
     * @return array|string|string[]
     */
    public function getImageAttribute($value)
    {
        return config('settings.images_domain') . str_replace('.jpg', '.webp', $value);
    }


    /**
     * @param $value
     *
     * @return array|string|string[]
     */
    public function getThumbAttribute($value)
    {
        return str_replace('.webp', '-thumb.webp', $this->image);
    }


    /**
     * @return float
     */
    public function getBasePriceAttribute(): float
    {
        if ($this->current_price > 0) {
            return $this->current_price;
        }

        return $this->starting_price;
    }


    /**
     * @return float
     */
    public function getDaysLeftAttribute(): float
    {
        return floor(now()->diffInDays($this->end_time));
    }


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
    public function scopeLast(Builder $query, $count = 12): Builder
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


    /**
     * @return array
     */
    public function attributesList(): array
    {
        return Helper::resolveCache('auction')->remember('attributes' . $this->id, config('cache.life'), function () {
            if ($this->attributes()->count() > 0) {
                $response = [];

                foreach ($this->attributes()->get() as $attribute) {
                    $response[] = [
                        'id' => $attribute->attribute_id,
                        'group' => $attribute->group_title,
                        'title' => $attribute->attribute->title,
                        'value' => $attribute->value,
                        'sort_order' => $attribute->attribute->sort_order,
                    ];
                }

                return collect($response)->sortBy('sort_order')->toArray();
            }

            return [];
        });
    }


    /**
     * @param Collection|null $bids
     *
     * @return bool
     */
    public function userHasLastBid(Collection $bids = null): bool
    {
        if ($bids && auth()->check() && (auth()->id() == $bids->first()->user_id)) {
            return true;

        } elseif ( ! $bids && auth()->check()) {
            $bids = $this->bids()->where('amount', '>=', $this->current_price)
                                  ->orderBy('created_at', 'desc')
                                  ->take(4)
                                  ->get();

            if (auth()->id() == $bids->first()->user_id) {
                return true;
            }
        }

        return false;
    }

}
