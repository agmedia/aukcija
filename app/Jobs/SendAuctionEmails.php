<?php

namespace App\Jobs;

use App\Mail\UserBid;
use App\Mail\UserBidReceived;
use App\Mail\UserOutbided;
use App\Models\Front\Catalog\Auction\Auction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAuctionEmails implements ShouldQueue
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
        Mail::to($this->user->email)->send(new UserBid($this->auction, $this->user));
        Mail::to(config('settings.admin_email'))->send(new UserBidReceived($this->auction, $this->user));

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
            Mail::to($email['email'])->send(new UserOutbided($this->auction, $email['user']));
        }
    }
}
