<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Breadcrumb;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Front\Blog;
use App\Models\Front\Catalog\Auction\Auction;
use App\Models\Front\Page;
use App\Models\Front\Faq;
use App\Models\Seo;
use App\Models\TagManager;
use Illuminate\Http\Request;

class CatalogRouteController extends FrontController
{

    /**
     * @param Request      $request
     * @param string       $group
     * @param Auction|null $auction
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function resolve(Request $request, string $group = null, Auction $auction = null)
    {
        if ($auction) {
            if ( ! $auction->status) {
                abort(404);
            }

            $auction->increment('viewed');

            $bc     = new Breadcrumb();
            $crumbs = $bc->auction($group, $auction)->resolve();
            $schema = $bc->auctionBookSchema($auction);

            $seo = Seo::getAuctionData($auction);
            $gdl = TagManager::getGoogleAuctionDataLayer($auction);

            $bids              = $auction->latestBids(4);
            $user_has_last_bid = $auction->userHasLastBid($bids);

            return view('front.catalog.auction.index', compact('auction', 'group', 'bids', 'user_has_last_bid', 'seo', 'crumbs', 'schema', 'gdl'));
        }

        $meta_tags = Seo::getMetaTags($request, 'filter');
        $crumbs    = (new Breadcrumb())->group($group)->resolve();

        return view('front.catalog.auction.list', compact('group', 'meta_tags', 'crumbs'));
    }


    /**
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        if ($request->has(config('settings.search_keyword'))) {
            if ( ! $request->input(config('settings.search_keyword'))) {
                return redirect()->back()->with(['error' => 'Oops..! Zaboravili ste upisati pojam za pretraživanje..!']);
            }

            $group  = null;
            $crumbs = null;

            $ids = Helper::search(
                $request->input(config('settings.search_keyword'))
            );

            return view('front.catalog.auction.list', compact('group', 'ids', 'crumbs'));
        }

        if ($request->has(config('settings.search_keyword') . '_api')) {
            $search = Helper::search(
                $request->input(config('settings.search_keyword') . '_api')
            );

            return response()->json($search);
        }

        return response()->json(['error' => 'Greška kod pretrage..! Molimo pokušajte ponovo ili nas kotaktirajte! HVALA...']);
    }


    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function page(Page $page)
    {
        return view('front.page', compact('page'));
    }


    /**
     * @param Blog $blog
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function blog(Blog $blog)
    {
        if ( ! $blog->exists) {
            $blogs = Blog::active()->get();

            return view('front.blog', compact('blogs'));
        }

        return view('front.blog', compact('blog'));
    }


    /**
     * @param Faq $faq
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function faq()
    {
        $faq = Faq::where('status', 1)->get();

        return view('front.faq', compact('faq'));
    }

}
