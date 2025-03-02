<?php

namespace App\Models\Back\Catalog\Auction;

use App\Models\Back\Catalog\Category;
use Illuminate\Database\Eloquent\Model;

class AuctionCategory extends Model
{

    /**
     * @var string $table
     */
    protected $table = 'auction_category';

    /**
     * @var array $guarded
     */
    protected $guarded = [];


    /**
     * Update Auction categories.
     *
     * @param array $categories
     * @param int   $auction_id
     *
     * @return array
     */
    public static function storeData(array $categories, int $auction_id): array
    {
        $created = [];
        self::where('auction_id', $auction_id)->delete();

        foreach ($categories as $category) {
            $cat = Category::find($category);

            if ($cat) {
                if ($cat->parent_id) {
                    $created[] = self::insert([
                        'auction_id'  => $auction_id,
                        'category_id' => $cat->parent_id
                    ]);
                }

                $created[] = self::insert([
                    'auction_id'  => $auction_id,
                    'category_id' => $category
                ]);
            }
        }

        return $created;
    }
}
