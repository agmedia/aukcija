<?php

namespace Database\Seeders;

use App\Models\Back\Catalog\Groups\Groups;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PagesSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create settings
        //DB::statement(Storage::get(base_path('/database/seeders/settings.txt')));
        
        $items = file_get_contents(base_path('/database/seeders/pages.json'));
        
        if ($items) {
            $items = json_decode($items, true);
            
            foreach ($items as $item) {
                DB::table('pages')->insert($item);
            }
        }


        // Groups
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
