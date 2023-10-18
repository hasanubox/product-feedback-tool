<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmails​ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message = null;
    /**
     * Create a new job instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscribers = User::all()->toArray();

        foreach ($subscribers as $subscriber)
        {
            \Mail::send('layouts.mail', ['msg' => $this->message, 'subscriber' => $subscriber], function ($m) use($subscriber) {
                $m->to($subscriber['email'], $subscriber['name']);
                $m->subject('Email Notification.');
            });
        }
    }
}
