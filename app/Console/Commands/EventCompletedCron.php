<?php

namespace App\Console\Commands;

use App\Models\UserEventLocation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EventCompletedCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event_completed:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Cron Job running at " . now());

        /*------------------------------------------
        --------------------------------------------
        Update users_event_locations with completed
        --------------------------------------------
        --------------------------------------------*/


        $events = UserEventLocation::where('due_date', Carbon::now('Europe/Bucharest')->toDateString())->get();

        foreach ($events as $event) {
            $event->status = 'in desfasurare';
            $event->save();
        }

        $events_end = UserEventLocation::where('due_date', Carbon::now('Europe/Bucharest')->subDay()->toDateString())->get();
        foreach ($events_end as $event) {
            $event->status = 'desfasurat';
            $event->save();
        }

        $this->info('Event statuses updated successfully!');
    }
}
