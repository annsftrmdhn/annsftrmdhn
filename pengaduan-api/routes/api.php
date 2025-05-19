<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengaduanController;

Route::apiResource('pengaduan', PengaduanController::class);
