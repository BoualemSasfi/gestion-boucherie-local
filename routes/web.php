<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Serial_controller;

use App\Http\Controllers\InformationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransfertController;
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
// ---------               caisse                                 ----------
// -------------------------------------------------------------------------
Route::controller(CaisseController::class)->group(function () {
    Route::get('/caisse', 'caisse')->name('caisse_home');
    Route::get('/caisse_teste', 'caisse')->name('caisse_teste');
    Route::get('/caisse/category/{id}', 'filtrage_des_produits')->name('caisse_filtrage');

});

//--------------------------------------------------------------------------
// ---------                Information                           ----------
// -------------------------------------------------------------------------
Route::controller(InformationController::class)->group(function () {
    Route::get('/admin/information', 'index');
    Route::put('/admin/information/{id}/update', 'update');
});

//--------------------------------------------------------------------------
// ---------                catégories                            ----------
// -------------------------------------------------------------------------
Route::controller(CategoryController::class)->group(function () {
    Route::get('/admin/category', 'index');
    Route::get('/admin/category/add', 'create');
    Route::post('/admin/category/add/save', 'store');
    Route::get('/admin/category/{id}/edit', 'edit');
    Route::put('/admin/category/{id}/update', 'update');
    Route::delete('/admin/category/{id}/delete', 'destroy');
});
//--------------------------------------------------------------------------
// ---------                Produits                              ----------
// -------------------------------------------------------------------------
Route::controller(ProduitController::class)->group(function () {
    Route::get('/admin/produit', 'index');
    Route::get('/admin/produit/add', 'create');
    Route::post('/admin/produit/add/save', 'store');
    Route::get('/admin/produit/{id}/edit', 'edit');
    Route::put('/admin/produit/{id}/update', 'update');
    Route::delete('/admin/produit/{id}/delete', 'destroy');
});
//-------------------------------------------------------------------------
// ---------                magasin                              ----------
// ------------------------------------------------------------------------
Route::controller(MagasinController::class)->group(function () {
    Route::get('/admin/magasin', 'index');
    Route::get('/admin/magasin/add', 'create');
    Route::post('/admin/magasin/add/save', 'store');
    Route::get('/admin/magasin/{id}/edit', 'edit');
    Route::put('/admin/magasin/{id}/update', 'update');
    Route::get('/admin/magasin/{id}/stock', 'stock');
    Route::delete('/admin/magasin/{id}/delete', 'destroy');
});
//-------------------------------------------------------------------------
// ---------                Stock                              ----------
// ------------------------------------------------------------------------
Route::controller(StockController::class)->group(function () {
    Route::get('/admin/stock', 'index');

    Route::get('/admin/stock/add', 'create');
    Route::get('/admin/stock/addup/', 'addup');
    Route::delete('/admin/stock/{id}/delet_add', 'delet_add');
    
    // add category ajax
    // Route::post('/admin/stock/addcat/{magasin}/{category}', 'add_category');
    
    Route::post(' /admin/stock/categorie/add/{id_stock}/{category}', 'addcat');
    Route::delete(' /admin/stock/categorie/supp/{id_stock}/{category}', 'suppcat');
    
    Route::post('/admin/stock/deletcat/{id}', 'deletcat');
    
    // ajaxe pour afficher la liste des catégories 
    Route::get('/admin/stock/category/{id}', 'cat_list');
    

    Route::get('/admin/stock/{id}/update_affich', 'update_affich');

    Route::put('/admin/stock/{id}/update', 'update');



    Route::post('/admin/stock/add/save', 'store');
    Route::get('/admin/stock/{id}/edit', 'edit');
    Route::get('/admin/stock/{id}/stock', 'stock');
    Route::delete('/admin/stock/{id}/delete', 'destroy');
});


//-------------------------------------------------------------------------
// ---------                transfert                            ----------
// ------------------------------------------------------------------------
Route::controller(TransfertController::class)->group(function () {
    Route::get('/admin/transfert/{id_atl}/{id_mag}/{id_magasin}', 'transfert');
    Route::post('/admin/transfert/validtransfert','validtransfert')->name('validtransfert');
});













require __DIR__ . '/auth.php';



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
