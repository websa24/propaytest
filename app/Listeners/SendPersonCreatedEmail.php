<?php

namespace App\Listeners;

use App\Events\PersonCreated;
use App\Jobs\SendPersonCreatedEmailJob;

class SendPersonCreatedEmail
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
    public function handle(PersonCreated $event): void
    {
        SendPersonCreatedEmailJob::dispatch($event->person);
    }
}
