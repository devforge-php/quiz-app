<?php

namespace App\Listeners;

use App\Events\AuthEvent;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ProfileEventListener
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
        Profile::create([
         'user_id' => $event->user->id,
         'image' => '',
         'user_name' => ''
        ]);
    }
}
