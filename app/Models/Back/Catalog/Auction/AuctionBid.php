<?php

namespace App\Models\Back\Catalog\Auction;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class AuctionBid extends Model
{

    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'auction_bid';

    /**
     * @var array $guarded
     */
    protected $guarded = [];

    /**
     * @var Request
     */
    protected $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }


    /**
     * Validate New Auction Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        // Validate the request.
        $request->validate([
            'auction_id' => 'required',
            'user_id'    => 'required',
            'amount'     => 'required',
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * Create and return new Auction Model.
     *
     * @return mixed
     */
    public function create()
    {
        $id = $this->insertGetId($this->getModelArray());

        if ($id) {
            $bid = $this->find($id);

            $this->updateAuctionCurrentPrice($bid->auction);

            return $bid;
        }

        return false;
    }


    /**
     * Update and return new Auction Model.
     *
     * @return mixed
     */
    public function edit()
    {
        $updated = $this->update($this->getModelArray(false));

        if ($updated) {
            $this->updateAuctionCurrentPrice($this->auction);

            return $this;
        }

        return false;
    }


    /**
     * @param bool $insert
     *
     * @return array
     */
    private function getModelArray(bool $insert = true): array
    {
        $response = [
            'auction_id' => $this->request->auction_id,
            'user_id'    => $this->request->user_id,
            'amount'     => $this->request->amount,
            'updated_at' => now()
        ];

        if ($insert) {
            $response['created_at'] = now();
        }

        return $response;
    }


    /**
     * @param Auction $auction
     *
     * @return bool
     */
    private function updateAuctionCurrentPrice(Auction $auction): bool
    {
        return $auction->update([
            'current_price' => $this->request->amount,
            'updated_at'    => now(),
        ]);
    }
}
