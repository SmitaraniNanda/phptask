<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\InvoiceRequested;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'customer' => [
                'name' => 'Smita',
                'email' => 'smita@gmail.com',
                'invoice_id' => 'INV-00123',
                'amount' => '150.00',
                'date' => now()->format('Y-m-d'),
            ]
        ];

        // Dispatch the event
        event(new InvoiceRequested($data));

        return response()->json(['message' => 'Invoice generation event dispatched.']);
    }
}
