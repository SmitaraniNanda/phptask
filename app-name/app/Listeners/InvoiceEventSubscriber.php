<?php

namespace App\Listeners;

use App\Events\InvoiceRequested;
use Illuminate\Support\Facades\Log;

class InvoiceEventSubscriber
{
    /**
     * Handle the InvoiceRequested event.
     */
    public function handleInvoiceRequested(InvoiceRequested $event)
    {
        Log::info('Subscriber handling InvoiceRequested event.', $event->data);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe($events)
    {
        $events->listen(
            InvoiceRequested::class,
            [InvoiceEventSubscriber::class, 'handleInvoiceRequested']
        );
    }
}