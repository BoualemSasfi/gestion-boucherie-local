<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Serial_controller;

use App\Http\Controllers\InformationController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('admin.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//--------------------------------------------------------------------------
// ---------                Information                           ----------
// --------------------------------------------------------------------------
Route::controller(InformationController::class)->group(function(){
    Route::get('/admin/information','index');
    Route::get('/admin/dossier_ajax', 'index_ajax');
    Route::put('/admin/information/{id}/update','update');
    
    // Route::post('/admin/dossier/{titre}/save', 'store');
    // Route::put('/admin/dossier/{id}/{titre}update', 'update_ajax');
    // Route::delete('/admin/dossier_ajax/{id}/delete', 'supp_ajax');
});
//--------------------------------------------------------------------------
// ---------                catégories                           ----------
// --------------------------------------------------------------------------
Route::controller(CategoryController::class)->group(function(){
    Route::get('/admin/category','index');
    Route::get('/admin/category/add','create');
    Route::post('/admin/category/add/save','store');
    Route::get('/admin/dossier_ajax', 'index_ajax');
    Route::put('/admin/information/{id}/update','update');
    
    // Route::post('/admin/dossier/{titre}/save', 'store');
    // Route::put('/admin/dossier/{id}/{titre}update', 'update_ajax');
    // Route::delete('/admin/dossier_ajax/{id}/delete', 'supp_ajax');
});

require __DIR__.'/auth.php';



// les route de la caisse 

Route::get('/caisse', function () {
    return view('caisse.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/test', function () {
//     return view('caisse.test');
// })->middleware(['auth', 'verified'])->name('dashboard');
// balance

// Route::get('/test1', [Serial_controller::class, 'showBalance']);
Route::get('/test', [Serial_controller::class, 'showBalance']);
