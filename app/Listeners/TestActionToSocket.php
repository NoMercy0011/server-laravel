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
        $url = rtrim( env('SOCKET_IO_URI'), '/').'/send-message';

        Http::post(env('SOCKET_IO_URI'), [
            "message" => $event->message,
            "url" => $url
        ]);
    }
}
