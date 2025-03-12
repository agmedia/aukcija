<?php

namespace App\Models\Front\Catalog\Auction;

use App\Models\Back\Catalog\Attributes\Attributes;
use Illuminate\Database\Eloquent\Model;

class AuctionAttribute extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'auction_attribute';

    /**
     * @var array $guarded
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attribute()
    {
        return $this->hasOne(Attributes::class, 'id', 'attribute_id');
    }
}
