<?php

namespace App\Helpers;

use App\Models\Back\Catalog\Auction\Auction;
use App\Models\Back\Orders\OrderAuction;
use App\Models\Front\Catalog\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AuctionHelper
{



    /**
     * @param Auction       $auction
     * @param Category|null $category
     * @param Category|null $subcategory
     *
     * @return string
     */
    public static function url(Auction $auction, Category $category = null, Category $subcategory = null): string
    {
        if ($subcategory) {
            return Str::slug($category->group) . '/' . $category->slug . '/' . $subcategory->slug . '/' . $auction->slug;
        }

        if ($category) {
            return Str::slug($category->group) . '/' . $category->slug . '/' . $auction->slug;
        }

        return '/';
    }



    /**
     * @param string $path
     *
     * @return string
     */
    public static function getCleanImageTitle(string $path): string
    {
        $from   = strrpos($path, '/') + 1;
        $length = strrpos($path, '-') - $from;

        return substr($path, $from, $length);
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public static function getFullImageTitle(string $path): string
    {
        $from   = strrpos($path, '/') + 1;
        $length = strrpos($path, '.') - $from;

        return substr($path, $from, $length);
    }


    /**
     * @param string $title
     *
     * @return string
     */
    public static function setFullImageTitle(string $title): string
    {
        return $title . '-' . Str::random(4);
    }

}
