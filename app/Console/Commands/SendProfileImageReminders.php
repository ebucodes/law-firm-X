<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Notifications\ProfileImageReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendProfileImageReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:profile_image_reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for Profile Image Reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clients = Client::whereNull('profile_image')->get();

        foreach ($clients as $client) {
            Notification::send($client, new ProfileImageReminder());
        }
    }
}
