<?php

namespace App\Jobs;

use App\Mail\PersonCreatedEmail;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable as QueueableTrait;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPersonCreatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, QueueableTrait, SerializesModels;

    public $person;

    /**
     * Create a new job instance.
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->person->email)->send(new PersonCreatedEmail($this->person));
    }
}
