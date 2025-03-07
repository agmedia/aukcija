<?php

namespace App\Models\Front\Catalog\Auction;

use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    
    /**
     * @var string $table
     */
    protected $table = 'auction_bid';

    /**
     * @var array $guarded
     */
    protected $guarded = [];
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function auction()
    {
        return $this->hasOne(Auction::class, 'id', 'auction_id');
    }
}
