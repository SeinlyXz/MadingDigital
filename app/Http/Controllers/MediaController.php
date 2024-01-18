<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MediaController extends Controller
{
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
        if(!$request->file('path')) {
            return redirect()->route('media.create')->with('Gagal', 'Gambar tidak boleh kosong');
        }
        if(!$request->pemilik) {
            return redirect()->route('media.create')->with('Gagal', 'Pemilik tidak boleh kosong');
        }
        if(!$request->pengupload) {
            return redirect()->route('media.create')->with('Gagal', 'Pengupload tidak boleh kosong');
        }
        // Function to check if the cover is png or jpeg format
        $path = explode('.', $request->file('path')->getClientOriginalName());
        // Always get the last value from $path
        $last_path = count($path) - 1;
        

        if ($path[$last_path] == 'JPG' || $path[$last_path] == 'JPEG' || $path[$last_path] == 'jpg' || $path[$last_path] == 'jpeg' || $path[$last_path] == 'png' || $path[$last_path] == 'PNG') {
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
                return redirect()->route('media.create')->with('Gagal', 'Resolusi gambar harus 16:9.');
            }
            $path_2 = explode('.', $request->file('path')->getClientOriginalName());
            $last_image = count($path_2) - 1;

            // change $path2[$last_image] to lowercase
            $path_2[$last_image] = strtolower($path_2[$last_image]);

            // dd($path_2[$last_image]);
            $path_image = $request->file('path')->store('public/image');
            // $path_image = $request->file('path')->store('storage/image');
            $path_image = $path_video = str_replace('public', 'storage', $path_image);

            $media = new Media();
            $media->pemilik = $request->pemilik;
            $media->path = $path_image;
            $media->pengupload = $request->pengupload;
            $media->type = $path_2[$last_image];
            // Set date uploaded in format tanggal-bulan-tahun jam:menit di waktu Indonesia Barat
            $media->uploaded_at = Carbon::now('Asia/Jakarta')->format('d-m-Y H:i');
            $media->save();
        } else if($path[$last_path] == 'mp4' || $path[$last_path] == 'mkv' || $path[$last_path] == 'MP4' || $path[$last_path] == 'MKV' || $path[$last_path] == 'MPEG' || $path[$last_path] == 'Mkv') {
            // Dapatkan format dari file yang dikirim
            $path_2 = explode('.', $request->file('path')->getClientOriginalName());

            // Ambil index terakhir dari $path_2
            $last_video = count($path_2) - 1;

            // change $path2[$last_image] to lowercase
            $path_2[$last_video] = strtolower($path_2[$last_video]);

            // Masukkan file ke dalam folder public/storage/video
            $path_video = $request->file('path')->store('public/video');

            // Change public/image/woV3gCWXXAxk0UsN1IsDPG60Aczioie6GfraV9Nn.jpg to storage/image/woV3gCWXXAxk0UsN1IsDPG60Aczioie6GfraV9Nn.jpg
            $path_video = $path_video = str_replace('public', 'storage', $path_video);

            // $path_video = $request->file('path')->store('storage/video');
            // dd($path_2[$last_video]);
            $media = new Media();
            $media->pemilik = $request->pemilik;
            $media->path = $path_video;
            $media->pengupload = $request->pengupload;
            $media->type = $path_2[$last_video];
            // Set date uploaded using carbon datetime format
            $media->uploaded_at = Carbon::now('Asia/Jakarta')->format('d-m-Y H:i');
            $media->save();
        } else {
            return redirect()->route('media.create')->with('Gagal', 'Format tidak didukung');
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
