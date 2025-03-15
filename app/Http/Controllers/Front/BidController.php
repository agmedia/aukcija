<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Jobs\SendAuctionEmails;
use App\Jobs\SendAuctionNotifications;
use App\Models\Back\Catalog\Auction\AuctionBid;
use App\Models\Front\Catalog\Auction\Auction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BidController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id'     => 'required',
            'amount' => 'required',
        ]);

        $auction = Auction::query()->where('id', $request->input('id'))->first();

        if (auth()->user() && $auction && $auction->end_time > now()) {
            // Create new bid. Update auction. Send emails.
            AuctionBid::create([
                'auction_id' => $auction->id,
                'user_id'    => auth()->id(),
                'amount'     => $request->input('amount'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $auction->update([
                'current_price' => $request->input('amount'),
                'updated_at'    => now(),
            ]);

            SendAuctionEmails::dispatchAfterResponse(
                $auction,
                auth()->user()
            );

            SendAuctionNotifications::dispatchAfterResponse(
                $auction,
                auth()->user()
            );

            return back()->with(['success' => 'Hvala na ponudi..!']);
        }

        return back()->with(['error' => 'Došlo je do greške..!']);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function storeApi(Request $request): JsonResponse
    {
        if ($request->has('id') && $request->has('amount')) {
            $this->store($request);

            return response()->json(['status' => 200]);
        }

        return response()->json(['status' => 500]);
    }

}
