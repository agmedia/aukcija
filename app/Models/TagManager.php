<?php

namespace App\Models;

use App\Models\Back\Orders\Order;
use App\Models\Front\Catalog\Auction\Auction;
use App\Models\Front\Catalog\Product;
use Darryldecode\Cart\CartCollection;

/**
 * Class Sitemap
 * @package App\Models
 */
class TagManager
{

    /**
     * @param Order $order
     *
     * @return array
     */
    public static function getGoogleSuccessDataLayer(Order $order)
    {
        $products = [];
        $shipping = 0;
        $tax      = 0;

        foreach ($order->products as $product) {
            $products[] = static::getGoogleProductDataLayer($product->real);
        }

        foreach ($order->totals()->get() as $total) {
            if ($total->code == 'subtotal') {
                $tax += $total->value - ($total->value / 1.05);
            }
            if ($total->code == 'shipping') {
                $tax      += $total->value - ($total->value / 1.25);
                $shipping = $total->value;
            }
        }

        $data = [
            'event'     => 'purchase',
            'ecommerce' => [
                'transaction_id' => (string) $order->id,
                'affiliation'    => 'Žuži webshop',
                'value'          => (float) $order->total,
                'tax'            => (float) number_format($tax, 2),
                'shipping'       => (float) number_format($shipping, 2),
                'currency'       => 'EUR',
                'items'          => $products
            ],
        ];

        return $data;
    }


    /**
     * @param Product $product
     *
     * @return array
     */
    public static function getGoogleAuctionDataLayer(Auction $auction): array
    {
        $item = [
            'item_id'        => $auction->sku,
            'item_name'      => $auction->name,
            'price'          => (float) str_replace(',', '.', $auction->current_price),
            'currency'       => 'EUR',
            'quantity'       => 1,
        ];

        return $item;
    }


    /**
     * @param CartCollection $cart_collection
     *
     * @return array
     */
    public static function getGoogleCartDataLayer(array $cart_collection): array
    {
        $items = [];

        foreach ($cart_collection['items'] as $item) {
            $items[] = $item->associatedModel->dataLayer;
        }

        return $items;
    }

}
