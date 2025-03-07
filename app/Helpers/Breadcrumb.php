<?php

namespace App\Helpers;

use App\Models\Front\Catalog\Auction\Auction;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Breadcrumb
{

    /**
     * @var array
     */
    private $schema = [];

    /**
     * @var array
     */
    private $breadcrumbs = [];


    /**
     * Breadcrumb constructor.
     */
    public function __construct()
    {
        $this->setDefault();
    }


    /**
     * @param               $group
     * @param Category|null $cat
     * @param null          $subcat
     *
     * @return $this
     */
    public function group(string $group = null)
    {
        $this->addGroup($group);

        return $this;
    }


    /**
     * @param               $group
     * @param Category|null $cat
     * @param null          $subcat
     * @param Product|null  $prod
     *
     * @return $this
     */
    public function auction(string $group, Auction $auction = null)
    {
        if ($auction) {
            $count = count($this->breadcrumbs) + 1;

            array_push($this->breadcrumbs, [
                '@type' => 'ListItem',
                'position' => $count,
                'name' => $auction->name,
                'item' => url($auction->url)
            ]);
        }

        return $this;
    }


    /**
     * @param Product|null $prod
     *
     * @return array
     */
    public function auctionBookSchema(Auction $auction = null)
    {
        if ($auction) {
            return [
                '@context' => 'https://schema.org/',
                '@type' => 'Book',
                'datePublished' => '',
                'description' => $auction->name,
                'image' => asset($auction->image),
                'name' => $auction->name,
                'url' => url($auction->url),
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'EUR',
                    'price' => number_format($auction->current_price, 2, '.', ''),
                    'sku' => $auction->sku,
                    'availability' => ($auction->quantity) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'
                ],
            ];
        }
    }


    /**
     * @return array
     */
    public function resolve()
    {
        $this->schema['itemListElement'] = $this->breadcrumbs;

        return $this->schema;
    }


    /**
     *
     */
    private function setDefault()
    {
        $this->schema = [
            '@context' => 'https://schema.org/',
            '@type' => 'BreadcrumbList'
        ];

        array_push($this->breadcrumbs, [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Naslovnica',
            'item' => route('index')
        ]);
    }


    /**
     * @param $group
     */
    public function addGroup($group)
    {
        array_push($this->breadcrumbs, [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $group ? Str::ucfirst($group) : 'Sve aukcije',
            'item' => route('catalog.route', ['group' => $group])
        ]);
    }
}
