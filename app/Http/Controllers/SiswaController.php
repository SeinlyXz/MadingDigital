<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media; // Sesuaikan dengan model Anda

class SiswaController extends Controller
{
    public function index(){
        // Misalnya, Anda ingin mengambil video
        $media = Media::where('pemilik', 'siswa')->get();
        // Ambil ID dari table media
        $id = Media::where('pemilik', 'siswa')->pluck('id');

        // Atau jika Anda ingin mengambil gambar
        // $media = Media::where('owner_type', 'siswa')
        //               ->where('media_type', 'gambar')
        //               ->get();

        return view('siswa.index', ['media' => $media, 'id' => $id]);
    }
}
