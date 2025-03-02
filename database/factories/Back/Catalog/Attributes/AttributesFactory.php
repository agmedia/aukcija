<?php

namespace Database\Factories\Back\Catalog\Attributes;

use App\Models\Back\Catalog\Attributes\Attributes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttributesFactory extends Factory
{
    
    protected $model = Attributes::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = fake()->word;
        
        return [
            'group' => Str::lower($group),
            'group_title' => Str::title($group),
            'title' => fake()->sentence,
            'description' => fake()->text,
            'type' => '',
            'sort_order' => 0,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
