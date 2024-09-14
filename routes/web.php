<?php

use Illuminate\Support\Facades\Route;
use App\Models\Media;
use App\Http\Controllers\{MediaController, SiswaController, GuruController, TataUsahaController};

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

Route::get('/tatausaha', [SiswaController::class, 'index']);
Route::get('/guru', [GuruController::class, 'index']);
Route::get('/siswa', [TataUsahaController::class, 'index']);
Route::get('/video/{filename}', [MediaController::class, 'serveVideo'])->name('video.serve');

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
        Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');

        // Menampilkan formulir untuk mengedit media
        Route::get('media/{media}/edit', [MediaController::class, 'edit'])->name('media.edit');

        // Mengupdate media
        Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
        
        // Menghapus media
        Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('/media', function() {
            return redirect()->route('dashboard');
        });
        
        Route::get('/dashboard', [MediaController::class, 'index'])->name('dashboard');

});

// Route::get('/video/{filename}', function ($filename) {
//     $path = storage_path('app/public/video/' . $filename);
    
//     if (!file_exists($path)) {
//         abort(404, 'File not found');
//     }
    
//     return response()->file($path);
// });