<?php

namespace App\Models\Back\Catalog\Auction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    use HasFactory;
    
    /**
     * @var string $table
     */
    protected $table = 'auction_bid';

    /**
     * @var array $guarded
     */
    protected $guarded = [];


}
