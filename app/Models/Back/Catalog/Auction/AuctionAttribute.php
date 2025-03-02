<?php

namespace App\Models\Back\Catalog\Auction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionAttribute extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'auction_attribute';

    /**
     * @var array $guarded
     */
    protected $guarded = [];


}
