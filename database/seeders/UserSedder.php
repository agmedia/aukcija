<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSedder extends Seeder
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
            "INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
              ('Filip Jankoski', 'filip@agmedia.hr', null, '" . bcrypt('majamaja001') . "', '', 0, '', NOW(), NOW()),
              ('Tomislav Jureša', 'tomislav@agmedia.hr', null, '" . bcrypt('bakanal') . "', '', 0, '', NOW(), NOW()),
              ('Bobo Customer', 'bobo@agmedia.hr', null, '" . bcrypt('majamaja001') . "', '', 0, '', NOW(), NOW()),
              ('Tomek Customer', 'tomek@agmedia.hr', null, '" . bcrypt('bakanal') . "', '', 0, '', NOW(), NOW())"
        );

        // create admins details
        DB::insert(
            "INSERT INTO `user_details` (`user_id`, `user_group_id`, `fname`, `lname`, `address`, `zip`, `city`, `state`, `phone`, `oib`, `company`, `can_bid`, `use_notifications`, `use_emails`, `avatar`, `bio`, `social`, `role`, `status`, `created_at`, `updated_at`) VALUES
              (1, 0, 'Filip', 'Jankoski', 'Kovačića 23', '44320', 'Kutina', 'Croatia', '', '', '', 1, 1, 1, 'media/avatars/avatar0.jpg', 'Lorem ipsum...', '790117367', 'master', 1, NOW(), NOW()),
              (2, 0, 'Tomislav', 'Jureša', 'Malešnica bb', '10000', 'Zagreb', 'Croatia', '', '', '', 1, 1, 1, 'media/avatars/avatar0.jpg', 'Lorem ipsum...', '', 'master', 1, NOW(), NOW()),
              (3, 0, 'Bobo', 'Customer', 'Customerska bb', '44320', 'Kutina', 'Croatia', '', '', '', 1, 1, 1, 'media/avatars/avatar0.jpg', 'Lorem ipsum...', '', 'customer', 1, NOW(), NOW()),
              (4, 0, 'Tomek', 'Customer', 'Customerska bb', '10000', 'Zagreb', 'Croatia', '', '', '', 1, 1, 1, 'media/avatars/avatar0.jpg', 'Lorem ipsum...', '', 'customer', 1, NOW(), NOW())"
        );
    }
}
