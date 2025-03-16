<?php

namespace Database\Seeders;

use App\Models\Back\Catalog\Attributes\Attributes;
use App\Models\Back\Catalog\Auction\Auction;
use App\Models\Back\Catalog\Auction\AuctionAttribute;
use App\Models\Back\Catalog\Auction\AuctionBid;
use App\Models\Back\Catalog\Auction\AuctionImage;
use App\Models\Back\Catalog\Groups\Groups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Attributes::factory(30)->create();
        
        Auction::factory(500)->create();
        
        AuctionAttribute::factory(1500)->create();
        
        AuctionImage::factory(1000)->create();
        
        AuctionBid::factory(2500)->create();


        $groups = [
            'Knjige', 'Zemljovidi', 'Filatelija', 'Numizmatika'
        ];

        foreach ($groups as $key => $group) {
            Groups::query()->insertGetId([
                'group' => Str::slug($group),
                'group_title' => $group,
                'title' => $group,
                'description' => fake()->sentence(),
                'type' => 'text',
                'sort_order' => $key + 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
