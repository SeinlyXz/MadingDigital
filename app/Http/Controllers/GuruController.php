<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class GuruController extends Controller
{
    public function index(){
        // Misalnya, Anda ingin mengambil video
        $media = Media::where('pemilik', 'guru')->get();
        // Ambil ID dari table media
        $id = Media::where('pemilik', 'guru')->pluck('id');

        // Atau jika Anda ingin mengambil gambar
        // $media = Media::where('owner_type', 'siswa')
        //               ->where('media_type', 'gambar')
        //               ->get();

        return view('guru.index', ['media' => $media, 'id' => $id]);
    }
}
