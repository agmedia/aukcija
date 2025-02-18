<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admins
        DB::insert(
            "CREATE VIEW `categories_view` AS `c`.`id`, `c`.`parent_id`, `ct`.`lang`, `ct`.`title`, `ct`.`description`, `ct`.`slug`, `ct`.`meta_title`, `ct`.`meta_description`, `c`.`image`, `c`.`icon`, `c`.`group`, `c`.`sort_order` FROM `categories` AS c JOIN `category_translations` AS ct ON `ct`.`category_id` = `c`.`id`;"
        );
        
    }
}
