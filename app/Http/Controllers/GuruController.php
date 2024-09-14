<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GuruController extends Controller
{
    /**
     * Display the media list and serve videos with cache control.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve media related to 'guru' and include cache-busting information
        $media = Media::where('pemilik', 'guru')->get();

        // Add cache-busting version parameter based on file modification time
        foreach ($media as $mediaItem) {
            // Ensure the path is correctly formed
            $filePath = storage_path('app/public/video/' . basename($mediaItem->path));

            // Check if the file exists before trying to get its modification time
            if (file_exists($filePath)) {
                $mediaItem->version = filemtime($filePath);
            } else {
                $mediaItem->version = time(); // Fallback to current time if file does not exist
            }
        }

        // Pass media data to the view
        return view('guru.index', ['media' => $media]);
    }
}
