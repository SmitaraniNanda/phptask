<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesforceWebhookController extends Controller
{
    public function userUpdated(Request $request)
    {
        // Log the incoming data
        Log::info('User updated from Salesforce:', $request->all());

        return response()->json(['status' => 'received'], 200);
    }
}
