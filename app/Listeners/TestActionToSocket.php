<?php

namespace App\Listeners;

use App\Events\TestEventReverb;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class TestActionToSocket
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
    public function handle(TestEventReverb $event): void
    {
        Http::post('https://ansd-web-socket-io.onrender.com/send-message', [
            "message" => $event->message,
        ]);
        // Http::post('http://localhost:5000/send-message', [
        //     "message" => $event->message,
        // ]);
    }
}
