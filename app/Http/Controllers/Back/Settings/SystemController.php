<?php

namespace App\Http\Controllers\Back\Settings;

use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Settings;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{

    public function index()
    {
        return view('back.settings.system');
    }
}
