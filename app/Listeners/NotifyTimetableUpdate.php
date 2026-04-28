<?php

namespace App\Listeners;

use App\Events\TimetableUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTimetableUpdate
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
    public function handle(TimetableUpdated $event): void
    {
        \Illuminate\Support\Facades\Log::info('Jadual waktu dikemaskini: ', [
            'class_id' => $event->timetable->kafa_class_id,
            'day' => $event->timetable->day_of_week,
            'slot' => $event->timetable->time_slot_id,
        ]);
        
        // In a real scenario, we could send database notifications to all teachers/parents of this class.
    }
}
