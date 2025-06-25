<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|file|max:2048', // 2MB max
        ]);

        // Store file to storage/app/public/uploads
        $path = $request->file('file')->store('public/uploads');

        $filename = basename($path);
        $url = asset("storage/uploads/{$filename}");

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
            'url' => $url,
        ]);
    }
}
