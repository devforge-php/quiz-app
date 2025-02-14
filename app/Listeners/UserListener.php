<?php

namespace App\Listeners;

use App\Events\AuthEvent;
use App\Models\Notifaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserListener
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
    public function handle(AuthEvent $event): void
    {
     Notifaction::create([
            'name' => "Yangi user tizimdan ro'yhatdan otdi ismi  " . $event->user->name . ' email ' . $event->user->email,
        ]);
        
    }
}
