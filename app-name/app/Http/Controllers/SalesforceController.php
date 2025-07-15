<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesforceController extends Controller
{
    /**
     * Redirect user to Salesforce login page
     */
    public function redirectToSalesforce()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => config('services.salesforce.client_id'),
            'redirect_uri'  => config('services.salesforce.redirect_uri'),
            'scope'         => 'api refresh_token',
        ]);

        return redirect(config('services.salesforce.login_url') . '/services/oauth2/authorize?' . $query);
    }

    /**
     * Handle Salesforce OAuth callback
     */
    public function handleCallback(Request $request)
    {
        $code = $request->query('code');

        // Exchange code for access token
        $tokenResponse = Http::asForm()
            ->withOptions(['verify' => false])
            ->post(
                config('services.salesforce.login_url') . '/services/oauth2/token',
                [
                    'grant_type'    => 'authorization_code',
                    'client_id'     => config('services.salesforce.client_id'),
                    'client_secret' => config('services.salesforce.client_secret'),
                    'redirect_uri'  => config('services.salesforce.redirect_uri'),
                    'code'          => $code,
                ]
            );

        if (! $tokenResponse->successful()) {
            return response()->json([
                'error'   => 'Failed to get access token',
                'details' => $tokenResponse->body(),
            ], 500);
        }

        $tokenData   = $tokenResponse->json();
        $accessToken = $tokenData['access_token'];
        $instanceUrl = $tokenData['instance_url'];

        // Save tokens to session
        session([
            'salesforce_access_token' => $accessToken,
            'salesforce_instance_url' => $instanceUrl,
        ]);

        return response()->json([
            'message' => 'Successfully authenticated with Salesforce.',
        ]);
    }

    /**
     * Fetch list of Salesforce Users and dump them
     */
    public function listUsers()
    {
        $accessToken = session('salesforce_access_token');
        $instanceUrl = session('salesforce_instance_url');

        $usersResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])
            ->withOptions(['verify' => false])
            ->get($instanceUrl . '/services/data/v60.0/query', [
                'q' => 'SELECT Id, Name, Username, Email FROM User LIMIT 10',
            ]);
  
        if (! $usersResponse->successful()) {
            return response()->json([
                'error'   => 'Failed to fetch users',
                'details' => $usersResponse->body(),
            ], 500);
        }

        $users = $usersResponse->json();

        // THIS is the dump you asked for:
        dd($users);
    }
}
