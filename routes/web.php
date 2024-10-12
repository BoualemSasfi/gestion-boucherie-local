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

use Barryvdh\DomPDF\Facade\Pdf;
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
    
    Route::get('/caisse_paccino', 'caisse_paccino')->name('caisse_paccino');
    Route::get('/caisse/category/{id}', 'filtrage_des_produits')->name('caisse_filtrage');
    
    Route::post('/vente/{id_facture}/{id_user}/{id_lestock}/{id_produit}/valeurs/{prix_unitaire}/{qte}/{prix_total}', 'Nouvelle_Vente')->name('nouvelle_vente');
    Route::get('/ventes/{id_facture}', 'Get_Liste_Ventes')->name('liste_ventes');
    Route::get('/supprimer-vente/{id_vente}', 'Supprimer_Vente')->name('supprimer_vente');
    Route::get('/total-facture/{id_facture}', 'Total_Facture')->name('total_facture');
    Route::get('/nouvelle-facture/{id_user}/{id_magasin}/{id_caisse}', 'Create_Facture')->name('nouvelle_facture');
    Route::put('/valider-facture/{id_user}/{id_facture}/{id_caisse}/{id_client}/valeurs/{total}/{versement}/{credit}/{etat}', 'Valider_Facture')->name('valider_facture');
    
    Route::put('/en-attente-facture/{id_facture}/valeurs/{total}', 'En_Attente_Facture')->name('en_attente_facture');
    Route::get('/liste-factures-enattente/{id_magasin}', 'Liste_Factures_Enattente')->name('liste_factures_enattente');
    Route::get('/lafacture-enattente/{id_facture}', 'Get_Facture_Enattente')->name('get_facture_enattente');

    Route::get('/historique-factures/{id_magasin}', 'Liste_Factures_Historique')->name('liste_factures_historique');
    Route::get('/chercher-facture/{id_facture}', 'Chercher_Facture')->name('chercher_facture');

    
    Route::get('/imprimer-ticket/{id_facture}', 'ImprimerTicket')->name('caisse_ticket');
    Route::get('/imprimer-ticket-credit/{id_facture}', 'ImprimerTicket')->name('caisse_ticket_credit');
    Route::get('/test_pdf', 'test_pdf')->name('caisse_teste_ticket');

    Route::get('/open-cash-drawer', 'CashDrawerController@open')->name('open.cash.drawer');

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

    // ajustisement de stock
    Route::post('/mettre-a-jour-quantite','ajouster')->name('ajouster');
});
//-------------------------------------------------------------------------
// ---------                Stock                              ----------
// ------------------------------------------------------------------------
Route::controller(StockController::class)->group(function () {
    Route::get('/admin/stock', 'index');

    Route::get('/admin/stock/add', 'create');
    Route::get('/admin/stock/addup/', 'addup');
    Route::delete('/admin/stock/{id}/delet_add', 'delet_add');
    
    Route::post(' /admin/stock/categorie/add/{id_stock}/{category}', 'addcat');

    Route::post(' /admin/stock/categorie/supp/{id_stock}/{category}', 'suppcat');
    
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
    Route::get('/admin/transfert_congele/{id_atl}/{id_mag}/{id_magasin}', 'transfert_congele');

    Route::post('/admin/transfert/validtransfert', 'validTransfert')->name('validtransfert');

    Route::get('admin/transfert_liste','liste');
    Route::get('admin/transfert/{id}','details');
    Route::get('admin/ajuste','ajste_liste');
    


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






