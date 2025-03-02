<?php

namespace Database\Factories\Back\Catalog\Auction;

use App\Models\Back\Catalog\Auction\Auction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AuctionImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auction_id' => fake()->numberBetween(1, Auction::count()),
            'image' => fake()->imageUrl,
            'default' => 0,
            'published' => 1,
            'sort_order' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
