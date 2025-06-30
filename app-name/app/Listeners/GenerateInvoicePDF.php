<?php
namespace App\Listeners;

use App\Events\InvoiceRequested;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GenerateInvoicePDF
{
    public function handle(InvoiceRequested $event)
    {
        $pdf = Pdf::loadView('pdf.invoice', $event->data);

        $filename = 'invoice-' . $event->data['customer']['invoice_id'] . '.pdf';
        Storage::put('invoices/' . $filename, $pdf->output());
    }
}
