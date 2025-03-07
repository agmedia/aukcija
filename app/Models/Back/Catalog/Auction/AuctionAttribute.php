<?php

namespace App\Models\Back\Catalog\Auction;

use App\Models\Back\Catalog\Attributes\Attributes;
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
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attribute()
    {
        return $this->hasOne(Attributes::class, 'id', 'attribute_id');
    }
    
    
    /**
     * @param array $attributes
     * @param int   $auction_id
     *
     * @return array
     */
    public static function storeData(array $attributes, int $auction_id): array
    {
        $created = [];
        self::where('auction_id', $auction_id)->delete();
        
        foreach ($attributes as $attribute) {
            $att = Attributes::find($attribute['id']);
            
            if ($att) {
                $created[] = self::insert([
                    'auction_id'   => $auction_id,
                    'attribute_id' => $attribute['id'],
                    'value'        => $attribute['value'],
                ]);
            }
        }
        
        return $created;
    }
}
