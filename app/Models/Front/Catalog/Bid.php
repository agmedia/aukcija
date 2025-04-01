<?php

namespace App\Models\Front\Catalog;

use App\Jobs\SendAuctionEmails;
use App\Jobs\SendAuctionNotifications;
use App\Mail\UserBid;
use App\Models\Back\Catalog\Auction\AuctionBid;
use App\Models\Front\Catalog\Auction\Auction;
use App\Models\User;
use App\Notifications\UserBidNotification;
use Illuminate\Support\Facades\Mail;

/**
 *
 */
class Bid
{

    /**
     * @var User|(User&\Illuminate\Contracts\Auth\Authenticatable)|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    /**
     * @var Auction|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private $auction;

    /**
     * @var float
     */
    private $bid_amount;

    /**
     * @var float
     */
    private $min_required_bid = 0;

    /**
     * @var AuctionBid|null
     */
    private $max_existing_bid = null;

    /**
     * Price that should be updated
     * on auction current_price.
     *
     * @var float
     */
    private $future_current_price = 0;

    /**
     * @var int
     */
    private $created_bid_id = 0;

    /**
     * @var array
     */
    private $created_bids_ids = [];

    /**
     * @var bool
     */
    private $has_errors = false;

    /**
     * @var bool
     */
    private $automatic_bid_created = false;


    /**
     * @param int|string   $auction_id
     * @param float|string $bid_amount
     */
    public function __construct(int|string $auction_id, float|string $bid_amount)
    {
        $this->user = auth()->user();
        $this->auction = Auction::query()->find($auction_id);
        $this->bid_amount = is_float($bid_amount) ? $bid_amount : floatval($bid_amount);

        if ($this->hasMissingData()) {
            return null;
        }

        $this->setBidParams();
    }


    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if ($this->user->details->can_bid
            && $this->auction->end_time > now()
            && $this->bid_amount >= $this->min_required_bid)
        {
            return true;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function isSameAsMaxBid()
    {
        if ($this->max_existing_bid && $this->bid_amount == $this->max_existing_bid->amount) {
            return true;
        }

        return false;
    }


    /**
     * @param string|null $target
     *
     * @return array
     */
    public function generateResponse(string $target = null): array
    {
        if ($target) {
            return BidResponse::{$target}();
        }

        if ($this->automatic_bid_created) {
            return BidResponse::outbid();
        }

        return BidResponse::success();
    }


    /**
     * @if bid is == min
     *       Create 1 true bid.
     * @if bid is greater than MIN
     *       Create 1 true bid. + 1 min+increment bid with true parent_id
     * @if bid is greater than MAX
     *       Create 1 true bid. + 1 max+increment bid with true parent_id
     *
     * @return $this
     */
    public function place(): self
    {
        // bid is == min. Create 1 true bid.
        $this->createAuctionBid($this->bid_amount);

        // bid is greater than MIN
        if ($this->bid_amount > $this->min_required_bid && $this->isMaxExistingBid('<')) {
            $this->createAuctionBid($this->min_required_bid, $this->created_bid_id);

            if ($this->isMaxExistingBid('=')) {
                $this->createFutureAuctionBid($this->min_required_bid);

                $this->automatic_bid_created = true;
            }

            // bid is greater than MAX
        } elseif ($this->isMaxExistingBid('>')) {
            $this->createFutureAuctionBid($this->max_existing_bid->amount);
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function updateAuctionCurrentPrice(): self
    {
        $updated = $this->auction->update([
            'current_price' => $this->future_current_price,
            'updated_at'    => now(),
        ]);

        if ( ! $updated) {
            $this->has_errors = true;
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function sendEmails(): self
    {
        if ($this->automatic_bid_created) {
            Mail::to($this->user->email)->send(new UserBid($this->auction, $this->user, $this->bid_amount));

            $this->setUser();
        }

        SendAuctionEmails::dispatchAfterResponse(
            $this->auction,
            $this->user
        );

        return $this;
    }


    /**
     * @param int $should_send
     *
     * @return $this
     */
    public function sendNotifications(int $should_send): self
    {
        if ($should_send) {
            if ($this->automatic_bid_created) {
                $this->user->notify(new UserBidNotification($this->auction, $this->user, $this->bid_amount));

                $this->setUser();
            }

            SendAuctionNotifications::dispatchAfterResponse(
                $this->auction,
                $this->user
            );
        }

        return $this;
    }


    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        if ($this->has_errors) {
            AuctionBid::query()->whereIn('id', $this->created_bids_ids)->delete();

            return true;
        }

        return false;
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @return bool
     */
    private function hasMissingData(): bool
    {
        if ( ! $this->auction || ! $this->user || ! $this->bid_amount > 0) {
            return true;
        }

        return false;
    }


    /**
     * @return self
     */
    private function setBidParams(): self
    {
        $this->min_required_bid = floatval($this->auction->current_price + $this->auction->min_increment);
        $this->future_current_price = $this->min_required_bid;

        $max = $this->auction->bids()->orderBy('amount', 'desc')->first();

        if ($max && $max->amount > $this->min_required_bid) {
            $this->max_existing_bid = $max;
        }

        return $this;
    }


    /**
     * @param float $amount
     * @param int   $parent_id
     * @param int   $user_id
     *
     * @return self
     */
    private function createAuctionBid(float $amount, int $parent_id = 0, int $user_id = 0): self
    {
        $this->created_bid_id = AuctionBid::query()->insertGetId([
            'auction_id' => $this->auction->id,
            'user_id'    => $user_id ?: $this->user->id,
            'parent_id'  => $parent_id,
            'amount'     => $amount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ( ! $this->created_bid_id) {
            $this->has_errors = true;

            return $this;
        }

        array_push($this->created_bids_ids, $this->created_bid_id);

        return $this;
    }


    /**
     * @param float $amount
     *
     * @return self
     */
    private function createFutureAuctionBid(float $amount): self
    {
        $this->future_current_price = $amount + $this->auction->min_increment;

        $this->createAuctionBid($this->future_current_price, $this->created_bid_id);

        return $this;
    }


    /**
     * @param string $operator
     *
     * @return bool
     */
    private function isMaxExistingBid(string $operator): bool
    {
        if ($operator == '>') {
            if ($this->max_existing_bid && $this->bid_amount > $this->max_existing_bid->amount) {
                return true;
            }

        } elseif ($operator == '<') {
            if ( ! $this->max_existing_bid) {
                return true;
            }

            if ($this->max_existing_bid && $this->bid_amount < $this->max_existing_bid->amount) {
                return true;
            }

        } elseif ($operator == '=') {
            if ($this->max_existing_bid) {
                return true;
            }
        }

        return false;
    }


    /**
     * @return self
     */
    private function setUser(): self
    {
        $user = User::query()->find($this->max_existing_bid->user_id);

        if ( ! $user) {
            $this->has_errors = true;

            return $this;
        }

        $this->user = $user;

        return $this;
    }
}