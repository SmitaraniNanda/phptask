<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\InvoiceRequested;
use App\Models\User;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';

    protected $description = 'Generate invoice PDFs for all users every 2 minutes';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $data = [
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'invoice_id' => 'INV-' . rand(10000, 99999),
                    'amount' => '150.00',
                    'date' => now()->format('Y-m-d H:i:s'),
                ],
            ];

            event(new InvoiceRequested($data));
        }

        // Write custom log
        $timestamp = now()->format('Y-m-d H:i:s');
        $logMessage = "Invoices generated for {$users->count()} users at {$timestamp}" . PHP_EOL;
        $filePath = storage_path('logs/my_custom_log.txt');
        file_put_contents($filePath, $logMessage, FILE_APPEND);

        $this->info('InvoiceRequested events dispatched and log written.');
    }
}