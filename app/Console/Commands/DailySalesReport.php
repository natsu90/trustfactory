<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SalesReportMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Cart;

class DailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-sales-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a daily sales report to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $carts = Cart::all();

        Mail::to(env('ADMIN_EMAIL_ADDRESS'))->send(new SalesReportMail($carts));
    }
}
