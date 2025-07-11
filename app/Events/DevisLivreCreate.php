<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DevisLivreCreate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $devis;
    public $user;

    public function __construct($devis, $user)
    {
        $this->devis = $devis;
        $this->user = $user;
    }

}
