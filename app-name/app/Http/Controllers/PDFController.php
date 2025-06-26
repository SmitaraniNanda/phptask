<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Example data to pass to the view
        $data = [
            'customer' => [
                'name' => 'Smita',
                'email' => 'smita@gmail.com',
                'invoice_id' => 'INV-00123',
                'amount' => '150.00',
                'date' => now()->format('Y-m-d'),
            ]
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');
    }
}
