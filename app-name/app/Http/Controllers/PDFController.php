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
                'name' => 'Snigdha',
                'email' => 'snigdha@gmail.com',
                'invoice_id' => 'INV-' . rand(1000, 9999),
                'amount' => '150.00',
                'date' => now()->format('Y-m-d'),
            ]
        ];

        event(new InvoiceRequested($data));

        return response()->json(['message' => 'Invoice generation triggered.']);
    }
}