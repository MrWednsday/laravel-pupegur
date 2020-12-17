<?php

namespace App\Listeners;

use App\Event\CommentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentReceived  $event
     * @return void
     */
    public function handle(CommentReceived $event)
    {
        //
    }
}
