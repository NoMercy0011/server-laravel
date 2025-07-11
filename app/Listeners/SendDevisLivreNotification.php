<?php

namespace App\Listeners;

use App\Events\DevisLivreCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\type;

class SendDevisLivreNotification
{
    public function __construct()
    {
        //
    }

    public function handle(DevisLivreCreate $event): void
    {
        $devis = $event->devis;
        $user = $event->user;
        $url = rtrim( env('SOCKET_IO_URI'), '/').'/devis-notification';

        Http::post( $url, [
            'type' => 'devis-livre',
            'message' => "Nouvelle devis ajouté",
            'user' => $user->pseudo,
            'devis' => $devis->id_devis,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
