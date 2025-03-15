<?php

namespace App\Jobs;

use App\Models\Front\Catalog\Auction\Auction;
use App\Models\User;
use App\Notifications\UserBidNotification;
use App\Notifications\UserBidReceivedNotification;
use App\Notifications\UserOutbidedNotification;
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
        $this->user->notify(new UserBidNotification($this->auction, $this->user));

        $admin = User::query()->where('email', config('settings.admin_email'))->first();

        if ($admin) {
            $admin->notify(new UserBidReceivedNotification($this->auction, $this->user));
        }

        $mails = [];
        $bids = $this->auction->bids()->get();

        foreach ($bids as $bid) {
            if ($bid->user->email != $this->user->email) {
                $mails[$bid->user->id] = [
                    'user' => $bid->user,
                    'email' => $bid->user->email,
                ];
            }
        }

        foreach ($mails as $email) {
            $user = User::query()->where('email', $email['email'])->first();

            if ($user) {
                $user->notify(new UserOutbidedNotification($this->auction, $this->user));
            }
        }
    }
}
