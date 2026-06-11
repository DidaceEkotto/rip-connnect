<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminLogoutController;
use App\Http\Controllers\Aides\AidesController;
use App\Http\Controllers\Article\ArticleFuneraireController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Deces\DeceController;
use App\Http\Controllers\Document\DocumentationController;
use App\Http\Controllers\Home\HomePageController;
use App\Http\Controllers\Marbrerie\MarbrerieController;
use App\Http\Controllers\Morgue\MorqueController;
use App\Http\Controllers\Pompes\PompeFunebreController;
use App\Http\Controllers\Service\ServicesController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/create-symlink', function () {
    if (is_link(public_path('storage'))) {
        return 'Le lien symbolique existe déjà !';
    }

    try {
        symlink(
            storage_path('app/public'),
            public_path('storage')
        );
        return 'Lien symbolique créé avec succès !';
    } catch (\Exception $e) {
        return 'Erreur : ' . $e->getMessage();
    }
}); // Par exemple, middleware pour admin


Route::get('/',[HomePageController::class, 'index'])->name('homePage');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix("deces")->group(function(){
    Route::get('/',[DeceController::class, 'index'])->name('deces.index');
    Route::get('/details/{identifiant}',[DeceController::class, 'details_dece'])->name('deces.details');
    Route::get('/details/photos/{identifiant}',[DeceController::class, 'details_dece_photo'])->name('deces.details.photo');
    Route::get('/details/programme/{identifiant}',[DeceController::class, 'details_dece_programme'])->name('deces.details.programme');
    Route::get('/details/temoignage/{identifiant}',[DeceController::class, 'details_dece_temoignage'])->name('deces.details.temoignage');
});

Route::prefix("morgues")->group(function(){
    Route::get('/',[MorqueController::class, 'index'])->name('morgue.index');
    Route::get('/{slug}',[MorqueController::class, 'morgue_details'])->name('morgue.details');
});

Route::prefix("nos-services")->group(function(){
    Route::get('/',[ServicesController::class, 'index'])->name('services.index');
    Route::get('/{slug}',[ServicesController::class, 'details_services'])->name('services.details');
});

Route::prefix('aides-conseils')->group(function () {
    Route::get('/',[AidesController::class, 'index'])->name('aides.index');
    Route::get('/details/{slug}',[AidesController::class, 'details'])->name('aides.details');
});

Route::prefix("arts-funeraires")->group(function(){
    Route::get('/pompes-funrebres',[PompeFunebreController::class, 'index'])->name('pompe.index');
    Route::get('/cercueil',[PompeFunebreController::class, 'cercueil'])->name('pompe.cercueil');
    Route::get('/marbrerie',[PompeFunebreController::class, 'marbrerie'])->name('pompe.marbrerie');
    Route::get('/gerbes-de-fleurs',[PompeFunebreController::class, 'gerbes_fleurs'])->name('pompe.gerbes_fleurs');
    Route::get('/details-produit/{slug}',[PompeFunebreController::class, 'details_pompe'])->name('pompe.details');
    Route::get('/details/produit/{slug_produit}',[PompeFunebreController::class, 'details_pompe_produit'])->name('pompe.details.produit');
    //Route::get('/details/produit/{slug}/{slug_produit}',[PompeFunebreController::class, 'details_pompe_produit'])->name('pompe.details.produit');
});


Route::prefix("marbreries")->group(function(){
    Route::get('/',[MarbrerieController::class, 'index'])->name('marbreries.index');
    Route::get('/details/{slug}',[MarbrerieController::class, 'details_marbrerie'])->name('marbreries.details');
    Route::get('/details/produit/{slug}/{slug_produit}',[MarbrerieController::class, 'details_marbreries_produit'])->name('marbreries.details.produit');
});

Route::prefix("article-funeraires")->group(function(){
    Route::get('/',[ArticleFuneraireController::class, 'index'])->name('article_funeraires.index');
});

Route::prefix("documents")->group(function(){
    Route::get('/',[DocumentationController::class, 'index'])->name('documents.index');
    Route::get('/details/{slug}',[DocumentationController::class, 'details_documentation'])->name('documents.details');
});

Route::prefix("contact")->group(function(){
    Route::get('/',[ContactController::class, 'index'])->name('contact.index');
});

Route::prefix("comment-publier-une-annonce")->group(function(){
    Route::get('/',[CommentPublierUneAnnonceController::class, 'index'])->name('comment-publier-une-annonce.index');
});

/*
|--------------------------------------------------------------------------
| Routes Utilisateurs
|--------------------------------------------------------------------------
*/

// Routes publiques utilisateur (guest uniquement)
Route::middleware('guest.user')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

// Routes protégées utilisateur
Route::middleware('auth.user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Routes Admin — préfixe /admin, complètement séparées
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Routes publiques admin (guest admin uniquement)
    Route::middleware('guest.admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        //Route::post('/login', [AdminLoginController::class, 'login'])->name('login.attempt');

    });

    // Routes protégées admin
    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/banniere', [AdminDashboardController::class, 'banniere'])->name('banniere');
        Route::get('/dece/list', [AdminDashboardController::class, 'dece_liste'])->name('dece.liste');
        Route::get('/dece/add', [AdminDashboardController::class, 'dece_add'])->name('dece.ajouter_dece');
        Route::get('/dece/edite/{id}', [AdminDashboardController::class, 'dece_edition'])->name('dece.edite');
        Route::get('/dece/photos/{id}', [AdminDashboardController::class, 'dece_photos'])->name('dece.photos');
        Route::get('/dece/programme/{id}', [AdminDashboardController::class, 'dece_programme'])->name('dece.programme');
        Route::get('/services', [AdminDashboardController::class, 'services'])->name('services.liste');
        Route::get('/services/ajouter', [AdminDashboardController::class, 'services_ajouter'])->name('services.ajouter');
        Route::get('/services/modifier/{id}', [AdminDashboardController::class, 'services_modifier'])->name('services.modifier');

        Route::get('/partenaires', [AdminDashboardController::class, 'partenaire_liste'])->name('partenaires.liste');
        Route::get('/partenaires/ajouter', [AdminDashboardController::class, 'partenaire_ajouter'])->name('partenaires.ajouter');

        Route::get('/faqs', [AdminDashboardController::class, 'faqs'])->name('faqs');
        Route::get('/produits', [AdminDashboardController::class, 'produits_liste'])->name('produits.liste');
        Route::get('/produits/ajouter', [AdminDashboardController::class, 'produits_ajouter'])->name('produits.ajouter');
        Route::get('/produits/modifier/{id}', [AdminDashboardController::class, 'produits_modifier'])->name('produits.modifier');
        Route::get('/aides', [AdminDashboardController::class, 'aides_list'])->name('aides.liste');
        Route::get('/aides/create', [AdminDashboardController::class, 'aides_create'])->name('aides.create');
        Route::get('/aides/edition/{id}', [AdminDashboardController::class, 'aides_edite'])->name('aides.edite');
        Route::get('/a-propos', [AdminDashboardController::class, 'a_propos'])->name('apropos');
        Route::get('/mot-du-president', [AdminDashboardController::class, 'mot_du_president'])->name('mot_du_president');
        Route::get('/morgues', [AdminDashboardController::class, 'morgues'])->name('morgues.index');
        Route::get('/morgues/create', [AdminDashboardController::class, 'morgues_create'])->name('morgues.create');
        Route::get('/morgues/edite/{id}', [AdminDashboardController::class, 'morgues_edite'])->name('morgues.edite');
        Route::post('/logout', [AdminLogoutController::class, 'logout'])->name('logout');
    });

});
