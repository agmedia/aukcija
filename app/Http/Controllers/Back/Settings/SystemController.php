<?php

namespace App\Http\Controllers\Back\Settings;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Settings;
use App\Notifications\TestNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function index()
    {
        $notifications_status = Settings::get('settings', 'notifications_status');

        return view('back.settings.system', compact('notifications_status'));
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function notificationStatus(Request $request): JsonResponse
    {
        $set = Settings::set('settings', 'notifications_status', $request->input('status'), false);

        if ($set) {
            Helper::flushCache('settings')->flush('settings'.'notifications_status');

            return response()->json(['status' => 200]);
        }

        return response()->json(['status' => 500]);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function notificationTest(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->notify(new TestNotification());

            return back()->with(['success' => 'Ponuda je uspješno snimljen!']);
        }

        return back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
    }
}
