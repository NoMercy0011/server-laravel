<?php

namespace App\Listeners;

use App\Events\CommandeCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class NotificationCommandeCreate
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
    public function handle(CommandeCreate $event): void
    {
        $commande = $event->commande;
        $user = $event->user;
        $url = rtrim( env('SOCKET_IO_URI'), '/').'/commande-notification';

        Http::post( $url, [
            'type' => 'commande',
            'message' => "Nouvelle commande ajouté",
            'user' => $user->pseudo,
            'devis' => $commande->id_commande,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
