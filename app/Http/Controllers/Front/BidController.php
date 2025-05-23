<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\FrontController;
use App\Models\Front\Catalog\Bid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BidController extends FrontController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id'     => 'required',
            'amount' => 'required',
        ]);

        $bid = new Bid($request->id, $request->amount);

        if ($bid->isValid()) {
            if ($bid->isSameAsMaxBid()) {
                $bid->setFutureCurrentPrice(record_bid: true)
                    ->updateAuctionCurrentPrice()
                    ->sendEmails()
                    ->sendNotifications(intval($this->notifications_status));

                return response()->json($bid->generateResponse('same_as_max'));
            }

            if ($bid->isFromSameUserAsMaxBid()) {
                $bid->updateMaxBid();

                return response()->json($bid->generateResponse('same_user_as_max'));
            }

            $bid->place()
                ->updateAuctionCurrentPrice()
                ->sendEmails()
                ->sendNotifications(intval($this->notifications_status));

            if ($bid->hasErrors()) {
                return response()->json($bid->generateResponse('error'));
            }

            return response()->json($bid->generateResponse());
        }

        return response()->json($bid->generateResponse('error'));
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
