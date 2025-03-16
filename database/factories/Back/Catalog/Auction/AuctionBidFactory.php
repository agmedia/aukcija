<?php

namespace Database\Factories\Back\Catalog\Auction;

use App\Models\Back\Catalog\Auction\Auction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AuctionBidFactory extends Factory
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
            'user_id' => fake()->randomElement([1, 2, 3, 4]),
            'amount' => fake()->randomFloat(3, 0, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
