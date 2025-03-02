<?php

namespace Database\Factories\Back\Catalog\Auction;

use App\Models\Back\Catalog\Attributes\Attributes;
use App\Models\Back\Catalog\Auction\Auction;
use App\Models\Back\Catalog\Auction\AuctionAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AuctionAttributeFactory extends Factory
{
    protected $model = AuctionAttribute::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auction_id' => fake()->numberBetween(1, Auction::count()),
            'attribute_id' => fake()->numberBetween(1, Attributes::count()),
            'value' => fake()->sentence(2),
            'data' => null
        ];
    }
}
