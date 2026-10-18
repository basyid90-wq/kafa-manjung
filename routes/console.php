<?php

use App\Models\School;
use App\Notifications\PlanExpiringNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Remind workspace owners 7 days and 1 day before a paid plan expires
Artisan::command('plans:remind', function () {
    $sent = 0;
    foreach ([7, 1] as $days) {
        School::whereIn('plan', ['personal', 'sekolah'])
            ->whereDate('plan_expires_at', now()->addDays($days)->toDateString())
            ->whereNotNull('owner_id')
            ->with('owner')
            ->each(function (School $school) use ($days, &$sent) {
                $school->owner?->notify(new PlanExpiringNotification($school, $days));
                $sent++;
            });
    }
    $this->info("Peringatan dihantar: {$sent}");
})->purpose('E-mel peringatan pakej hampir tamat');

Schedule::command('plans:remind')->dailyAt('09:00');
