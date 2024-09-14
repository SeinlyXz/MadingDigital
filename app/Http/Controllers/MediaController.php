<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MediaController extends Controller
{
    public function serveVideo($filename)
    {
        $path = storage_path('app/public/video/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->download($path, null, [], null);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = Media::all();
        return view('dashboard', [
            'medias' => $medias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('media.create',[
            'media' => new Media()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate if file path is present
            if (!$request->file('path')) {
                throw new \Exception('Gambar atau video tidak boleh kosong');
            }
    
            // Validate if pemilik is present
            if (!$request->pemilik) {
                throw new \Exception('Pemilik tidak boleh kosong');
            }
    
            // Validate if pengupload is present
            if (!$request->pengupload) {
                throw new \Exception('Pengupload tidak boleh kosong');
            }
    
            // Function to check if the cover is png, jpeg, or video format
            $path = explode('.', $request->file('path')->getClientOriginalName());
            $last_path = count($path) - 1;
    
            if (!in_array(strtolower($path[$last_path]), ['jpg', 'jpeg', 'png', 'mp4', 'mkv', 'mpeg'])) {
                throw new \Exception('Format tidak didukung');
            }
    
            if (in_array(strtolower($path[$last_path]), ['jpg', 'jpeg', 'png'])) {
                // Function to check if the cover is png or jpeg format
                // Cek aspect ratio
                $image = $request->file('path');
                $imageDimensions = getimagesize($image->getPathname());
    
                // Memeriksa resolusi gambar
                $imageWidth = $imageDimensions[0];
                $imageHeight = $imageDimensions[1];
    
                // Memeriksa apakah rasio aspek adalah 16:9
                $aspectRatio = $imageWidth / $imageHeight;
                if (abs($aspectRatio - (16 / 9)) > 0.01) {
                    throw new \Exception('Resolusi gambar harus 16:9.');
                }
    
                // Process the image
                $path_2 = explode('.', $request->file('path')->getClientOriginalName());
                $last_image = count($path_2) - 1;
    
                $path_2[$last_image] = strtolower($path_2[$last_image]);
    
                $path_image = $request->file('path')->store('public/image');
                $path_image = str_replace('public', 'storage', $path_image);
    
                $media = new Media();
                $media->pemilik = $request->pemilik;
                $media->path = $path_image;
                $media->pengupload = $request->pengupload;
                $media->type = $path_2[$last_image];
                $media->uploaded_at = Carbon::now('Asia/Jakarta')->format('d-m-Y H:i');
                $media->save();
            } elseif (in_array(strtolower($path[$last_path]), ['mp4', 'mkv', 'mpeg'])) {
                // Process video file
                $path_2 = explode('.', $request->file('path')->getClientOriginalName());
                $last_video = count($path_2) - 1;
    
                $path_2[$last_video] = strtolower($path_2[$last_video]);
    
                $path_video = $request->file('path')->store('public/video');
                $path_video = str_replace('public', 'storage', $path_video);
    
                $media = new Media();
                $media->pemilik = $request->pemilik;
                $media->path = $path_video;
                $media->pengupload = $request->pengupload;
                $media->type = $path_2[$last_video];
                $media->uploaded_at = Carbon::now('Asia/Jakarta')->format('d-m-Y H:i');
                $media->save();
            }
        } catch (\Exception $e) {
            return redirect()->route('media.create')->with('Gagal', $e->getMessage());
        }
    
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        // return redirect()->route('dashboard')->with('error', 'Sistem sedang dalam perbaikan, Hapus dan Upload ulang media');
        return view('media.edit',[
            'media' => $media
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media){
        if (!$request->pemilik) {
            return redirect()->route('media.edit', $media)->with('Gagal', 'Pemilik tidak boleh kosong');
        }
        if (!$request->pengupload) {
            return redirect()->route('media.edit', $media)->with('Gagal', 'Pengupload tidak boleh kosong');
        }
        
        if ($request->hasFile('path')) {
            // Hapus gambar/video lama jika ada
            $path = $media->path;  // Combine relative path for public disk
            $path = explode('storage/', $path); // Split path into array
            if(Storage::disk('public')->exists($path[1])) {
                Storage::disk('public')->delete($path[1]);
            }

            // Function to check if the cover is png or jpeg format
            $path = explode('.', $request->file('path')->getClientOriginalName());
            // Always get the last value from $path
            $last_path = count($path) - 1;
            if (
                $path[$last_path] == 'JPG' || $path[$last_path] == 'JPEG' ||
                $path[$last_path] == 'jpg' || $path[$last_path] == 'jpeg' ||
                $path[$last_path] == 'png' || $path[$last_path] == 'PNG'
            ) {
                // Function to check if the cover is png or jpeg format
                $path_2 = explode('.', $request->file('path')->getClientOriginalName());
                $last_image = count($path_2) - 1;

                // change $path2[$last_image] to lowercase
                $path_2[$last_image] = strtolower($path_2[$last_image]);

                $path_image = $request->file('path')->store('public/image');
                $path_image = $request->file('path')->store('storage/image');
                // $path_image = $request->file('path')->store('storage/image');

                $media->path = $path_image;
                $media->type = $path_2[$last_image];
            } elseif ($path[$last_path] == 'mp4' || $path[$last_path] == 'mkv' || $path[$last_path] == 'MP4' || $path[$last_path] == 'MKV' || $path[$last_path] == 'MPEG' || $path[$last_path] == 'Mkv') {
                $path_2 = explode('.', $request->file('path')->getClientOriginalName());
                $last_video = count($path_2) - 1;

                // change $path2[$last_image] to lowercase
                $path_2[$last_video] = strtolower($path_2[$last_video]);

                $path_video = $request->file('path')->store('public/video');
                $path_video = $request->file('path')->store('storage/video');
                // $path_video = $request->file('path')->store('storage/video');
                // dd($path_2[$last_video]);

                $media->path = $path_video;
                $media->type = $path_2[$last_video];
            } else {
                return redirect()->route('media.edit', $media)->with('Gagal', 'Format tidak didukung');
            }
        }
        $media->pemilik = $request->pemilik;
        $media->pengupload = $request->pengupload;
        $media->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil Mengupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        try {
            // Path dari database storage/image/4abvseNa2yCk9fc0U9gqW2sQwQUwcp5DT5af8BW4.jpg
            // Path dari storage local storage\app\public\image\4abvseNa2yCk9fc0U9gqW2sQwQUwcp5DT5af8BW4.jpg
            $path = $media->path;  // Combine relative path for public disk
            $path = explode('storage/', $path); // Split path into array
            // dd(Storage::disk('public')->exists($path[1]));

            if(Storage::disk('public')->exists($path[1])) {
                Storage::disk('public')->delete($path[1]);
            }
            // Menghapus data Media dari database
            $media->delete();
            
            return redirect()->route('dashboard')
                ->with('success', 'Media berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Terjadi kesalahan saat menghapus media.');
        }
    }
}
