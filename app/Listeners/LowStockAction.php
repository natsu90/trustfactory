<?php

namespace App\Listeners;

use App\Events\LowStockQuantity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;

class LowStockAction
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockQuantity $event): void
    {
        $product = $event->product;

        Mail::to(env('ADMIN_EMAIL_ADDRESS'))->send(new LowStockNotification($product));
    }
}
