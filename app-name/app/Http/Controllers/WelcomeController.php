<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'Welcome! You are authenticated.']);
    }
}

