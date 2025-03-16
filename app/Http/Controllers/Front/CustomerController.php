<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Country;
use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Front\AgCart;
use App\Models\Front\Checkout\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends FrontController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (session()->has(config('session.cart'))) {
            //dd($request->session()->previousUrl());
            /*if ($request->session()->previousUrl() == config('app.url') . 'login') {
                $cart = new AgCart(session(config('session.cart')));

                if ($cart->get()['count'] > 0) {
                    return redirect()->route('kosarica');
                }
            }*/
        }

        $user = auth()->user();
        $countries = Country::list();

        CheckoutSession::forgetAddress();

        return view('front.customer.index', compact('user', 'countries'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orders(Request $request)
    {
        $user = auth()->user();
        $orders = $user->bids()->orderBy('created_at', 'DESC')->paginate(config('settings.pagination.front'));

        return view('front.customer.moje-narudzbe', compact('user', 'orders'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function notifications(Request $request)
    {
        $user = auth()->user();
        $notifications = $user->notifications()->orderBy('created_at', 'DESC')->paginate(config('settings.pagination.front'));

        return view('front.customer.moje-notifikacije', compact('user', 'notifications'));
    }


    public function details(Request $request)
    {
        $user = auth()->user();

        return view('front.customer.details', compact('user'));
    }


    /**
     * @param Request $request
     * @param User    $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, User $user)
    {
        $updated = $user->validateFrontRequest($request)->edit();

        if ($updated) {
            return redirect()->route('moj.racun', ['user' => $updated])->with(['success' => 'Korisnik je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Oops..! Greška prilikom snimanja.']);
    }


    /**
     * @param Request|null $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markNotificationsAsRead(Request $request = null)
    {
        $user = auth()->user();
        $user->unreadNotifications()->update(['read_at' => now()]);

        return back()->with(['success' => 'Notifikacije su pročitane..!']);
    }


    /**
     * @param Request $request
     *
     * @return int
     */
    public function readOneNotification(Request $request)
    {
        $request->validate(['id' => 'required']);
        $user = auth()->user();

        if ($user) {
            $unread = $user->unreadNotifications()->where('id', $request->input('id'))->first();

            Log::info($unread);

            if ($unread) {
                return $unread->markAsRead();
            }
        }

        return 0;
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changeSettings(Request $request): JsonResponse
    {
        $request->validate([
            'target' => 'required',
            'status' => 'required'
        ]);

        Log::info($request->all());

        $user = auth()->user();

        if ($user) {
            if ($request->input('target') == "use_emails") {
                $updated = $user->details()->update(['use_emails' => ($request->input('status') == 'true') ? 1 : 0]);
            }

            if ($request->input('target') == "use_notifications") {
                $updated = $user->details()->update(['use_notifications' => ($request->input('status') == 'true') ? 1 : 0]);
            }

            if ($updated) {
                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 300]);
    }
}
