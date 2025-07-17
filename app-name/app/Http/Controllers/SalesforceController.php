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

        $tokenResponse = Http::asForm()
            ->withOptions(['verify' => false])
            ->post(config('services.salesforce.login_url') . '/services/oauth2/token', [
                'grant_type'    => 'authorization_code',
                'client_id'     => config('services.salesforce.client_id'),
                'client_secret' => config('services.salesforce.client_secret'),
                'redirect_uri'  => config('services.salesforce.redirect_uri'),
                'code'          => $code,
            ]);

        if (! $tokenResponse->successful()) {
            return response()->json([
                'error'   => 'Failed to get access token',
                'details' => $tokenResponse->body(),
            ], 500);
        }

        $tokenData   = $tokenResponse->json();
        $accessToken = $tokenData['access_token'];
        $instanceUrl = $tokenData['instance_url'];

        session([
            'salesforce_access_token' => $accessToken,
            'salesforce_instance_url' => $instanceUrl,
        ]);

        return response()->json([
            'message'        => 'Successfully authenticated with Salesforce.',
            'access_token'   => $accessToken,
            'instance_url'   => $instanceUrl,
            'user_id_url'    => $tokenData['id'] ?? null,
        ]);
    }

    /**
     * Fetch list of Salesforce Users
     */
    public function listUsers(Request $request)
    {
        $accessToken = $request->header('SF-Access-Token') ?? session('salesforce_access_token');
        $instanceUrl = $request->header('SF-Instance-Url') ?? session('salesforce_instance_url');

        $instanceUrl = trim($instanceUrl, "\"'");

        if (!$accessToken || !$instanceUrl) {
            return response()->json([
                'error' => 'Missing Salesforce session data'
            ], 401);
        }

        $usersResponse = Http::withToken($accessToken)
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

        return response()->json($usersResponse->json());
    }

    /**
     * Update a Salesforce User
     */
    public function updateUser(Request $request, $userId)
    {
        $accessToken = $request->header('SF-Access-Token') ?? session('salesforce_access_token');
        $instanceUrl = $request->header('SF-Instance-Url') ?? session('salesforce_instance_url');

        $instanceUrl = trim($instanceUrl, "\"'");

        if (!$accessToken || !$instanceUrl) {
            return response()->json([
                'error' => 'Missing Salesforce session data'
            ], 401);
        }

        $fields = $request->all();

        if (empty($fields)) {
            return response()->json([
                'error' => 'No fields provided for update.',
            ], 422);
        }

        $url = $instanceUrl . '/services/data/v60.0/sobjects/User/' . $userId;

        $updateResponse = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->withOptions(['verify' => false])
            ->patch($url, $fields);

        if ($updateResponse->status() === 204) {
            return response()->json([
                'message' => 'User updated successfully.'
            ]);
        }

        return response()->json([
            'error'   => 'Failed to update user.',
            'details' => $updateResponse->body(),
        ], $updateResponse->status());
    }
}