<?php

namespace App\Models\Front\Catalog\Auction;

use Illuminate\Database\Eloquent\Model;

class AuctionImage extends Model
{
    /**
     * @var string
     */
    protected $table = 'auction_images';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    /**
     * @param $value
     *
     * @return array|string|string[]
     */
    public function getImageAttribute($value)
    {
        return str_replace('.jpg', '.webp', $value);
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

}
