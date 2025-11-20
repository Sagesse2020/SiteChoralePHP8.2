<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ChoristeController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\PubliciteController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\RepetitionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\WelcomeController;

// ------------------------
// ROUTES PUBLIQUES
// ------------------------
Route::view('/mission', 'Details.mission')->name('mission');
Route::view('/vision', 'Details.vision')->name('vision');
Route::view('/historique', 'Details.historique')->name('historique');
Route::view('/evenements', 'evenements')->name('evenements');
Route::view('/admin', 'admin')->name('admin');
Route::view('/home', 'home')->name('home');
Route::view('/info', 'infos')->name('infos');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

     // ------------------------
    // Commentaires
    // ------------------------
Route::get('/commentaires', [CommentaireController::class, 'index'])->name('commentaires.index');
Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])
    ->middleware('auth')
    ->name('commentaires.destroy');



// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('throttle:5,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/usersCreate', [AuthController::class, 'createUser'])->name('users');
Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::get('/stats', [StatistiqueController::class, 'index'])->name('statistiques');


// Mot de passe oublié
Route::prefix('password')->name('password.')->group(function () {
    Route::get('reset', [PasswordResetController::class, 'showResetForm'])->name('request');
    Route::post('email', [PasswordResetController::class, 'sendResetLink'])->name('email');
    Route::get('reset/{token}', [PasswordResetController::class, 'showNewPasswordForm'])->name('reset');
    Route::post('reset', [PasswordResetController::class, 'resetPassword'])->name('update');
});

 // ------------------------
    // GROUPES
    // ------------------------

      // vue de creation d'un groupe vocal
  Route::get('/createGroupe', [GroupeController::class, 'create'])->name('groupes_vocaux.create'); //Cette route affiche le formulaire de création d'un choriste
       // vue d'affichage de la liste des groupes vocaux
  Route::post('/createGroupe', [GroupeController::class, 'store'])->name('groupes_vocaux.store');
  Route::get('/indexGroupe', [GroupeController::class, 'index'])->name('groupes_vocaux.index');

   // ------------------------
    // CHORISTES
    // ------------------------
      // vue de creation d'un choriste
  Route::get('/createChoriste', [ChoristeController::class, 'create'])->name('choristes.create'); //Cette route affiche le formulaire de création d'un choriste
       // vue d'affichage de la liste des choristes
  Route::post('/createChoriste', [ChoristeController::class, 'store'])->name('choristes.store');
  Route::get('/indexChoriste', [ChoristeController::class, 'index'])->name('choristes.index');
  Route::get('/choristes/{id}/edit', [ChoristeController::class, 'edit'])->name('choristes.edit');
  Route::put('/choristes/{id}', [ChoristeController::class, 'update'])->name('choristes.update');
  Route::delete('/choristes/{id}', [ChoristeController::class, 'destroy'])->name('choristes.destroy');

   // ------------------------
    // GALERIES
    // ------------------------
      // vue de creation de repetition
  Route::get('/createGalerie', [GalerieController::class, 'create'])->name('galeries.create'); //Cette route affiche le formulaire de création d'un choriste
       // vue d'affichage des repetitions
  Route::post('/createGalerie', [GalerieController::class, 'store'])->name('galeries.store');
  Route::get('/indexGalerie', [GalerieController::class, 'index'])->name('galeries.index');
    Route::get('/galeries/{galerie}/edit', [GalerieController::class, 'edit'])->name('galeries.edit');
    Route::put('/galeries/{galerie}', [GalerieController::class, 'update'])->name('galeries.update');
    Route::delete('/galeries/{galerie}', [GalerieController::class, 'destroy'])->name('galeries.destroy');
    // Afficher toutes les images d'une galerie
    Route::get('/galeries/{galerie}', [GalerieController::class, 'show'])->name('galeries.show');


// ------------------------
// ROUTES PROTÉGÉES (auth)
// ------------------------
  Route::middleware('auth')->group(function () {

    // Logout
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil utilisateur
        Route::get('/profil', [UserController::class, 'profil'])->name('profil');
        Route::get('/edit', [UserController::class, 'profile'])->name('profile');
        Route::post('/update', [UserController::class, 'update'])->name('profile-update');
        Route::post('/profile/photo', [UserController::class, 'updatePhoto'])->name('profile.photo');
        Route::get('/usersIndex', [UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('users.update');

    // ------------------------
    // Accueil
    // ------------------------
        Route::get('/accueilGroupe', function () {
        return view('groupes_vocaux.accueil');
        })->name('app_accueilGroupe');

         Route::get('/accueilGalerie', function () {
         return view('galeries.accueil');
         })->name('app_accueilGalerie');

        Route::get('/accueilChoriste', function () {
        return view('choristes.accueil');
        })->name('app_accueilChoriste');


    // ------------------------
    // PUBLICITES
    // ------------------------
      Route::get('/accueilPublicite', function () {
    return view('publicites.accueil');
      })->name('app_accueilPublicite');
      // vue de creation de repetition
       Route::get('/createPublicite', [PubliciteController::class, 'create'])->name('publicites.create'); //Cette route affiche le formulaire de création d'un choriste
       Route::post('/createPublicite', [PubliciteController::class, 'store'])->name('publicites.store');
       Route::get('/indexPublicite', [PubliciteController::class, 'index'])->name('publicites.index');
       Route::get('/publicites/{publicite}/edit', [PubliciteController::class, 'edit'])->name('publicites.edit');
       Route::put('/publicites/{publicite}', [PubliciteController::class, 'update'])->name('publicites.update');
       Route::delete('/publicites/{publicite}', [PubliciteController::class, 'destroy'])->name('publicites.destroy');

    // ------------------------
    // PUBLICATIONS
    // ------------------------
     Route::get('/accueilPublication', function () {
    return view('publications.accueil');
  })->name('app_accueilPublication');
      // vue de creation d'un choriste
  Route::get('/createPublication', [PublicationController::class, 'create'])->name('publications.create'); //Cette route affiche le formulaire de création d'un choriste
       // vue d'affichage de la liste des choristes
  Route::post('/createPublication', [PublicationController::class, 'store'])->name('publications.store');
  Route::get('/indexPublication', [PublicationController::class, 'index'])->name('publications.index');
  Route::get('/publications/{publication}/edit', [PublicationController::class, 'edit'])->name('publications.edit');
  Route::put('/publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
  Route::delete('/publications/{publications}', [PublicationController::class, 'destroy'])->name('publications.destroy');

    // ------------------------
    // EVENEMENTS
    // ------------------------
    Route::get('/accueilEvenement', function () {
    return view('evenements.accueil');
  })->name('app_accueilEvenement');
      // vue de creation d'un choriste
  Route::get('/createEvenement', [EvenementController::class, 'create'])->name('evenements.create'); //Cette route affiche le formulaire de création d'un choriste
       // vue d'affichage de la liste des choristes
  Route::post('/createEvenement', [EvenementController::class, 'store'])->name('evenements.store');
  Route::get('/indexEvenement', [EvenementController::class, 'index'])->name('evenements.index');
        Route::get('{id}', [EvenementController::class, 'show'])->name('evenements.show');
        Route::get('albums', [EvenementController::class, 'showAlbums'])->name('evenements.albums');
    });
    Route::get('/evenements/{id}/edit', [EvenementController::class, 'edit'])->name('evenements.edit');
      Route::delete('/evenements/{id}', [EvenementController::class, 'destroy'])->name('evenements.destroy');
      Route::put('/evenements/{evenement}', [EvenementController::class, 'update'])->name('evenements.update');

    // ------------------------
    // PAGES GENERALES
    // ------------------------
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::view('actualites', 'pages.actualites')->name('actualites');
        Route::view('evenement', 'pages.evenement')->name('evenement');
        Route::view('galerie', 'pages.galerie')->name('galerie');
        Route::view('contact', 'pages.contact')->name('contact');
        Route::view('apropos', 'pages.apropos')->name('apropos');
    });




