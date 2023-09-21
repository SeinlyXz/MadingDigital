<?php

use Illuminate\Support\Facades\Route;
use App\Models\Media;
use App\Http\Controllers\{MediaController, SiswaController, GuruController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // $medias = Media::all();
    // return view('welcome',[
    //     'medias' => $medias
    // ]);
    return redirect('siswa');
});

Route::get('/siswa', function(){
    $media = Media::where('pemilik', 'siswa')->get();
    return view('siswa.index', ['media' => $media]);
});

Route::get('/guru', function(){
    $media = Media::where('pemilik', 'guru')->get();
    return view('guru.index', ['media' => $media]);
});

Route::middleware([
    
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    
    ])->group(function () {

        // Menampilkan formulir untuk membuat media baru
        Route::get('media/create', [MediaController::class, 'create'])->name('media.create');

        // Menyimpan media yang baru dibuat
        Route::post('media', [MediaController::class, 'store'])->name('media.store');

        // Menampilkan media tertentu
        Route::get('media/{medium}', [MediaController::class, 'show'])->name('media.show');

        // Menampilkan formulir untuk mengedit media
        Route::get('media/{medium}/edit', [MediaController::class, 'edit'])->name('media.edit');

        // Mengupdate media
        Route::put('media/{medium}', [MediaController::class, 'update'])->name('media.update');
        
        // Menghapus media
        Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('/media', function() {
            return redirect()->route('dashboard');
        });
        Route::get('/dashboard', function () {
            
            $medias = Media::all();
            return view('dashboard',[

            'medias' => $medias
            
        ]);
    })->name('dashboard');

});
