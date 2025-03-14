<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Helpers\Njuskalo;
use App\Helpers\Recaptcha;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Mail\ContactFormMessage;
use App\Models\Back\Catalog\Auction\AuctionBid;
use App\Models\Front\Catalog\Auction\Auction;
use App\Models\Front\Page;
use App\Models\Sitemap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BidController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        if ($this->bidRequestPass($request)) {
            AuctionBid::create([
                'auction_id' => $request->input('id'),
                'user_id'    => auth()->id(),
                'amount'     => $request->input('amount'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Auction::query()->update([
                'current_price' => $request->input('amount'),
                'updated_at' => now(),
            ]);
        }

        return back()->with(['success' => 'Hvala na ponudi..!']);
    }


    /**
     * @param Request $request
     *
     * @return bool
     */
    private function bidRequestPass(Request $request): bool
    {
        if (auth()->user() && $request->has('id') && $request->has('amount')) {
            return true;
        }

        return false;
    }

}
