<?php

namespace App\Jobs;

use App\Models\Front\Catalog\Auction\Auction;
use App\Models\User;
use App\Notifications\UserBidNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendAuctionNotifications implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Auction $auction,
        protected User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(new UserBidNotification());
    }
}
