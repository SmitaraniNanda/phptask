<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|max:2048', //  Limit size to 2MB
        ]);

        // Store the file inside storage/app/public/uploads
        $path = $request->file('file')->store('public/uploads');

        // Get public URL
        $filename = basename($path);
        $url = asset("storage/uploads/{$filename}");

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
            'url' => $url,
        ]);
    }
}
