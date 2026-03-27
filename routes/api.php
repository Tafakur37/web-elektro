
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------- 
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Cohort detail API for admin dashboard modal
Route::get('/cohort/{cohort}', function ($cohort) {
    $tahunMasuk = 2019 + $cohort;
    
    $kadets = User::where('role', 'kadet')
        ->whereRaw('SUBSTRING(identifier, 2, 4) = ?', [$tahunMasuk])
        ->orderBy('identifier')
        ->select('id', 'name', 'identifier', 'email', 'tanggal_lahir')
        ->get();
    
    return response()->json($kadets);
})->middleware('auth');

