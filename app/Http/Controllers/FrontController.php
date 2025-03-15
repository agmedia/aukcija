<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    protected $notifications_status;

    public function __construct()
    {
        //
        $uvjeti_kupnje = Helper::resolveCache('page')->remember('subgroup' . Str::slug('Uvjeti kupnje'), config('cache.life'), function () {
            return Page::where('subgroup', 'Uvjeti kupnje')->get();
        });
        View::share('uvjeti_kupnje', $uvjeti_kupnje);

        //
        $nacini_placanja = Helper::resolveCache('page')->remember('group' . Str::slug('Načini plaćanja'), config('cache.life'), function () {
            return Page::where('group', 'Načini plaćanja')->get();
        });
        View::share('nacini_placanja', $nacini_placanja);

        //
        $this->notifications_status = Settings::get('settings', 'notifications_status');
        View::share('notifications_status', $this->notifications_status);
    }

}
