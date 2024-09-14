<?php

namespace App\Http\Controllers;

use App\Models\TataUsaha;
use Illuminate\Http\Request;
use App\Models\Media;

class TataUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve media related to 'tata_usaha' and include cache-busting information
        $media = Media::where('pemilik', 'tata-usaha')->get();
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
        return view('tataUsaha.index', ['media' => $media]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TataUsaha $tataUsaha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TataUsaha $tataUsaha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TataUsaha $tataUsaha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TataUsaha $tataUsaha)
    {
        //
    }
}
