<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Auction\AuctionBid;
use Illuminate\Http\Request;

class BidController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search') && ! empty($request->search)) {
            $bids = AuctionBid::query()->with('user', 'auction')->orderBy('created_at', 'DESC')->paginate(config('settings.pagination.back'));
        } else {
            $bids = AuctionBid::query()->with('user', 'auction')->orderBy('created_at','DESC')->paginate(config('settings.pagination.back'));
        }

        return view('back.catalog.bids.index', compact('bids'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Attributes               $attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuctionBid $bid)
    {

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the attribute.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AuctionBid $bid)
    {

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the attribute .']);
    }
}
