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
    public static function categoryString(Auction $auction, Category $category = null, Category $subcategory = null): string
    {
        $data        = static::resolveCategories($auction, $category, $subcategory);
        $category    = $data['category'];
        $subcategory = $data['subcategory'];
        $catstring   = '';

        if ($category) {
            $catstring = '<span class="fs-xs ms-1"><a href="' . route('catalog.route', ['group' => Str::slug($category->group), 'cat' => $category->slug]) . '">' . $category->title . '</a> ';
        }

        if ($subcategory) {
            $substring = '</span><span class="fs-xs ms-1"><a href="' . route('catalog.route',
                    ['group' => Str::slug($category->group), 'cat' => $category->slug, 'subcat' => $subcategory->slug]) . '">' . $subcategory->title . '</a></span>';

            return $catstring . $substring;
        }

        return $catstring;
    }


    /**
     * @param Auction       $auction
     * @param Category|null $category
     * @param Category|null $subcategory
     *
     * @return string
     */
    public static function url(Auction $auction, Category $category = null, Category $subcategory = null): string
    {
        $data        = static::resolveCategories($auction, $category, $subcategory);
        $category    = $data['category'];
        $subcategory = $data['subcategory'];

        if ($subcategory) {
            return Str::slug($category->group) . '/' . $category->slug . '/' . $subcategory->slug . '/' . $auction->slug;
        }

        if ($category) {
            return Str::slug($category->group) . '/' . $category->slug . '/' . $auction->slug;
        }

        return '/';
    }


    /**
     * @param Auction       $auction
     * @param Category|null $category
     * @param Category|null $subcategory
     *
     * @return array
     */
    public static function resolveCategories(Auction $auction, Category $category = null, Category $subcategory = null): array
    {
        /*if ( ! $category) {
            $category = $auction->category();
        }

        if ( ! $subcategory) {
            $psub = $auction->subcategory();

            if ($psub) {
                foreach ($category->subcategories()->get() as $sub) {
                    if ($sub->id == $psub->id) {
                        $subcategory = $psub;
                    }
                }
            }
        }*/

        return [
            'category'    => $category,
            'subcategory' => $subcategory
        ];
    }


    /**
     * @param Builder $query
     * @param array   $request
     *
     * @return Builder
     */
    public static function queryCategories(Builder $query, array $request): Builder
    {
        $query->whereHas('categories', function ($query) use ($request) {
            if ($request['group'] && ! $request['cat'] && ! $request['subcat']) {
                $query->where('group', $request['group']);
            }

            if ($request['cat'] && ! $request['subcat']) {
                $query->where('category_id', $request['cat']);
            }

            if ($request['subcat']) {
                $query->where('category_id', $request['subcat']);
            }
        });

        return $query;
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


    /**
     * @param int|string $order_id
     *
     * @return bool
     */
    public static function makeAvailable($order_id): bool
    {
        $ops = OrderAuction::query()->where('order_id', $order_id)->get();

        foreach ($ops as $op) {
            Auction::query()->where('id', $op->auction_id)->increment('quantity', $op->quantity);
        }

        return true;
    }
}
