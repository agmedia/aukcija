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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auction = new Auction();

        $data           = $auction->getRelationsData();
        $active_actions = null;

        return view('back.catalog.auction.edit', compact('data', 'active_actions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auction = new Auction();

        $stored = $auction->validateRequest($request)->create();

        if ($stored) {
            $auction->storeImages($stored);

            return redirect()->route('auctions.edit', ['auction' => $stored])->with(['success' => 'Artikl je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Auction $auction
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auction)
    {
        $data = $auction->getRelationsData();

        $groups = Groups::all()->pluck('title', 'id');

        return view('back.catalog.auction.edit', compact('auction', 'groups', 'data'));
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
