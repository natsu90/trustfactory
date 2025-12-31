<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;
// use Illuminate\Support\Facades\Schedule;
use Illuminate\Console\Scheduling\Schedule;
use Carbon\Carbon;

class DailySalesReportTest extends TestCase
{
    public function testSetup()
    {
        $event = collect(app(Schedule::class)->events())->first(function ($event) {
            return str_contains($event->command, 'app:daily-sales-report');
        });

        $this->assertEquals('0 20 * * *', $event->expression);
    }

    public function testExecute()
    {
        $schedule = app(Schedule::class);

        // Test on a Monday
        Carbon::setTestNow(Carbon::parse('next monday 8pm')); // next Monday 8pm
        
        $events = collect($schedule->dueEvents(app()));
        
        $this->assertTrue(
            $events->contains(function ($event) {
                return str_contains($event->command, 'app:daily-sales-report');
            })
        );
    }
}