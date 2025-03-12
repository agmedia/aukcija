<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Groups\Groups;

use App\Models\Back\Catalog\Category;
use App\Models\Back\Catalog\Auction\Auction;

use App\Models\Back\Catalog\Auction\AuctionCategory;
use App\Models\Back\Catalog\Auction\AuctionImage;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class AuctionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Auction $auction)
    {
        $query = $auction->filter($request);

        $auctions = $query->paginate(20)->appends(request()->query());

        if ($request->has('status')) {

        }

        //$categories = (new Category())->getList(false);
        /*$authors    = Author::all()->pluck('title', 'id');*/
        $groups = Groups::all()->pluck('title', 'id');
        $counts = [];//Auction::setCounts($query);

        return view('back.catalog.auction.index', compact('auctions', 'groups', /*'authors', 'publishers',*/ 'counts'));
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
     * @param Auction                  $auction
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        $updated = $auction->validateRequest($request)->edit();

        if ($updated) {
            $auction->storeImages($updated);

            //$auction->addHistoryData('change');

            return redirect()->route('auctions.edit', ['auction' => $updated])->with(['success' => 'Artikl je uspješno snimljen!']);
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
    public function destroy(Request $request, Auction $auction)
    {
        AuctionImage::where('auction_id', $auction->id)->delete();
        //AuctionCategory::where('auction_id', $auction->id)->delete();

        Storage::deleteDirectory(config('filesystems.disks.auctions.root') . $auction->id);

        $destroyed = Auction::destroy($auction->id);

        if ($destroyed) {
            return redirect()->route('auctions')->with(['success' => 'Artikl je uspješno snimljen!']);
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
    public function destroyApi(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');

            AuctionImage::where('auction_id', $id)->delete();
            AuctionCategory::where('auction_id', $id)->delete();

            Storage::deleteDirectory(config('filesystems.disks.auctions.root') . $id);

            $destroyed = Auction::destroy($id);

            if ($destroyed) {
                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 300]);
    }


    /**
     * @param       $items
     * @param int   $perPage
     * @param null  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginateColl($items, $perPage = 20, $page = null, $options = []): LengthAwarePaginator
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
