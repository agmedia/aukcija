<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Auction\Auction;
use App\Models\Back\Catalog\Auction\AuctionBid;
use App\Models\User;
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
        $bids = AuctionBid::query()->with('user', 'auction')
                                   ->orderBy('created_at', 'DESC')
                                   ->paginate(config('settings.pagination.back'));

        return view('back.catalog.bids.index', compact('bids'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auctions = Auction::query()->pluck('name', 'id')->toArray();
        $users = User::query()->pluck('name', 'id')->toArray();

        return view('back.catalog.bids.edit', compact('auctions', 'users'));
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
        $bid = new AuctionBid();

        $stored = $bid->validateRequest($request)->create();

        if ($stored) {
            return redirect()->route('bids.edit', ['bid' => $stored])->with(['success' => 'Ponuda je uspješno snimljen!']);
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
    public function edit(AuctionBid $bid)
    {
        $auctions = Auction::query()->pluck('name', 'id')->toArray();
        $users = User::query()->pluck('name', 'id')->toArray();

        return view('back.catalog.bids.edit', compact('bid', 'users', 'auctions'));
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
        $updated = $bid->validateRequest($request)->edit();

        if ($updated) {
            return redirect()->route('bids.edit', ['bid' => $updated])->with(['success' => 'Ponuda je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
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
        $destroyed = $bid->delete();

        if ($destroyed) {
            return redirect()->route('bids')->with(['success' => 'Ponuda je uspješno obrisana!']);
        }

        return redirect()->route('bids')->with(['error' => 'Ops..! Greška prilikom brisanja.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyApi(Request $request)
    {
        if ($request->has('id')) {
            $destroyed = AuctionBid::destroy($request->input('id'));

            if ($destroyed) {
                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 300]);
    }
}
