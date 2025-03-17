<?php

namespace Database\Factories\Back\Catalog\Auction;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AuctionFactory extends Factory
{
    
    private $groups = [
        'Knjige', 'Zemljovidi', 'Numizmatika'
    ];
    
    private $prices = [
        20, 100, 250, 500
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $group = fake()->randomElement($this->groups);
        $price = fake()->randomElement($this->prices);
        
        return [
            'sku' => fake()->unique()->randomNumber(5),
            'ean'  => fake()->unique()->ean13(),
            'group' => $group,
            'name' => $name,
            'description'  => fake()->text,
            'meta_title' => $name,
            'meta_description' => fake()->text(100),
            'image' => fake()->imageUrl,
            'slug' => Str::slug($name),
            'url' => env('APP_URL') . '/' . Str::slug($group) . '/' . Str::slug($name),
            'starting_price' => $price,
            'current_price' => $price,
            'reserve_price' => 0,
            'min_increment' => $price / 10,
            'start_time' => now()->subDay(),
            'end_time' => now()->addMonths(2),
            'status' => 1,
            'tax_id' => 1,
            'viewed' => fake()->randomNumber(3),
            'featured' => 0,
            'sort_order' => 0,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
