<?php

namespace App\Console\Commands;

use App\Models\UserEventLocation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateEventToEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-event-to-end:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status at 15.00 with desfasurat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Updating event statuses to desfasurat at". now());

        $events_end = UserEventLocation::where('due_date', Carbon::now('Europe/Bucharest')->subDay()->toDateString())
            ->where('status', 'in desfasurare')
            ->get();

        foreach ($events_end as $event) {
            $event->status = 'desfasurat';
            $event->save();
        }

        $this->info('Event statuses updated successfully!');
    }
}
