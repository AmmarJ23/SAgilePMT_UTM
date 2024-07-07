<?php

namespace App\Console;

use App\Calendar;
use App\Task;
use App\Notifications\ReminderEmailNotification;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $dueDate = now()->addDays(2)->toDateString();

        // Find tasks due in 2 days
        $tasks = Task::whereDate('end_date', $dueDate)->get();
        Log::info('Tasks due in 2 days: ' . $tasks->toJson()); // Log tasks data

        foreach ($tasks as $task) {
            Notification::route('mail', 'user@example.com')->notify(new ReminderEmailNotification($task));
        }

        // Find calendar events due in 2 days
        $events = Calendar::whereDate('end_date', $dueDate)->get();
        Log::info('Events due in 2 days: ' . $events->toJson()); // Log events data

        foreach ($events as $event) {
            Notification::route('mail', 'user@example.com')->notify(new ReminderEmailNotification($event));
        }
    })->daily();
}


    /**
     * Register the commands for the application.
     *
     * @return void
     */
//     protected function commands()
// {
//     $this->load(__DIR__.'/Commands');

//     // Load additional commands if any
//     // require base_path('routes/console.php');

//     // Register your custom command
//     $this->commands([
//         \App\Console\Commands\SendReminderNotifications::class,
//     ]);
// }

}
