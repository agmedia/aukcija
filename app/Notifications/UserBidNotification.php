<?php

namespace App\Notifications;

use App\Models\Front\Catalog\Auction\Auction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class UserBidNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Auction $auction,
        protected User $user,
        protected float|null $amount = null,
    ) {
        if (is_null($amount)) {
            $this->amount = $this->auction->current_price;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $auction_link = route('catalog.route', ['group' => Str::slug($this->auction->group), 'auction' => $this->auction->slug]);

        return [
            'icon' => 'success',
            'title' => 'Vaša ponuda je bila uspješna.',
            'message' => 'Dali ste ponudu od ' . $this->amount . ' na aukciju ' . '<a href="' . $auction_link . '">' . $this->auction->name . '</a>'
        ];
    }
}
