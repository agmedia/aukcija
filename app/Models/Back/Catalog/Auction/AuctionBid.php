<?php

namespace App\Models\Back\Catalog\Auction;

use App\Models\User;
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
    
    
    public function user()
    {
        return $this->belongsTo(User::class,  'user_id', 'id');
    }
    
    
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
}
