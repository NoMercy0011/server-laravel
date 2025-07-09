<?php

namespace App\Http\Controllers;

use App\Events\TestEventReverb;
use Illuminate\Http\Request;

class MessageUpdatedController extends Controller
{
    public function send(Request $request){
        $message = $request->message;

        broadcast(new TestEventReverb($message))->toOthers();

        if(! $message) {
            return response()->json([
                'status' => 403,
                'erreur' => "message vide",
            ]);
        }
        return response()->json([
            'status' => 'Message envoyé avec succès!',
            'message' => $message,
        ]);
    }
}
