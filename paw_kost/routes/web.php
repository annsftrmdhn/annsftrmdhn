<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RoomController;

// --- Halaman Utama ---
Route::get('/', function () {
    return view('welcome');
});

// --- Halaman Login ---
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// --- Login Logic ---
Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // Dummy login (username: Ibu Kost, password: PunyaKost100Pintu)
    if ($username === 'Ibu Kost' && $password === 'PunyaKost100Pintu') {
        Session::put('logged_in', true);
        return redirect('/rooms');
    }

    return back()->with('error', 'Username atau password salah');
});

// --- Logout ---
Route::get('/logout', function () {
    Session::forget('logged_in');
    return redirect('/login');
})->name('logout');

// --- Halaman Daftar Kamar (Hanya bisa diakses setelah login) ---
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
