<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatCostumerController;

Route::get('/obat/filter', [ObatCostumerController::class, 'filter']);