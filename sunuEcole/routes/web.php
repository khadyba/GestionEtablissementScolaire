<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ElevesController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\EmploisDuTempsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Routes pour les utilisateurs
Route::prefix('users')->name('users.')->group(function () {
    Route::get('create', [UsersController::class, 'create'])->name('create');
    Route::post('/', [UsersController::class, 'store'])->name('store');
    Route::get('login', [UsersController::class, 'connection'])->name('login');
    Route::post('login', [UsersController::class, 'LoginForm'])->name('login.submit');
});

     // Routes pour creer  les administrateurs
Route::prefix('administrateurs')->name('administrateurs.')->group(function () {
     Route::get('create', [AdministrateurController::class, 'create'])->name('create');
     Route::post('/', [AdministrateurController::class, 'store'])->name('store');
});

// Routes pour la gestion de la connexion des administrateurs
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});
// route pour les administrateur dejat connecter 
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdministrateurController::class, 'index'])->name('admin.dashboard')->middleware('auth');
    Route::post('/etablissement/creer', [EtablissementController::class, 'store'])->name('etablissements.store');
    Route::get('/etablissement/formulaire', [EtablissementController::class, 'create'])->name('etablissement.formulaire');
    Route::get('/admin/profile/edit', [AdministrateurController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile/update', [AdministrateurController::class, 'update'])->name('admin.profile.update');
    Route::get('/classes/create', [ClasseController::class, 'create'])->name('classes.create');
    Route::post('/classes', [ClasseController::class, 'store'])->name('classes.store');
    Route::get('/listDesClasses',[ClasseController::class,'index'])->name('classes.index');
    Route::get('/classes/{id}/edit',[ClasseController::class,'edit'])->name('classes.edit');
    Route::put('/classes/{id}/update',[ClasseController::class,'update'])->name('classes.update');
    Route::delete('/classes/{id}',[ClasseController::class,'destroy'])->name('classes.destroy');

    // route pour les affectations
    Route::get('/classes/{id}/eleves', [ClasseController::class, 'assignStudents'])->name('classes.assign.students');
    Route::get('/classes/{id}/professeurs', [ClasseController::class, 'assignTeachers'])->name('classes.assign.teachers');
    Route::post('/classes/{id}/professeurs', [ClasseController::class, 'storeAssignedTeacher'])->name('classes.assign.teachers.store');

// route pour la gestion des emplois du temps
    Route::get('/emplois_du_temps', [EmploisDuTempsController::class, 'index'])->name('emplois_du_temps.index');
    Route::get('/emplois_du_temps/upload', [EmploisDuTempsController::class, 'create'])->name('emplois_du_temps.create');
    Route::post('/emplois_du_temps/upload', [EmploisDuTempsController::class, 'store'])->name('emplois_du_temps.store');
    Route::get('/emplois-du-temps/{id}/download', [EmploisDuTempsController::class, 'download'])->name('emplois_du_temps.download');

// route pour l'ajout des professeur par l'administration 
    Route::get('/listProfAjouter',[AdministrateurController::class,'index'])->name('list.index');
    Route::get('/formulairAjout',[AdministrateurController::class,'formulaire'])->name('affiche.formulaire');
    Route::post('/AjouterProf',[AdministrateurController::class,'ajouterProfesseur'])->name('Ajout.ajouterProfesseur');
});

// route pour permettre au prof d'ajouter des cours
Route::get('/cours/create', [ProfesseurController::class, 'create'])->name('cours.create');
Route::post('/cours', [ProfesseurController::class, 'store'])->name('cours.store');


// route pour les dashbord des utilisateur dejat connection 
Route::get('/prof/dashboard', [ProfesseurController::class, 'index'])->name('prof.dashboard')->middleware('auth');
Route::get('/eleve/dashboard', [ElevesController::class, 'index'])->name('eleve.dashboard')->middleware('auth');
Route::get('/parent/dashboard', [ParentsController::class, 'index'])->name('parent.dashboard')->middleware('auth');

// route pour pemermetre au professeur de completer leur profil 
Route::get('/professeurs/complete-profil', [ProfesseurController::class, 'showCompleteProfileForm'])->name('professeurs.complete-profile');
Route::post('/professeurs/complete-profil', [ProfesseurController::class, 'completeProfile'])->name('professeurs.complete-profile.store');

// route pour permetre au eleves de completer leur profils apres leur connection
Route::get('eleves/complete-profile', [ElevesController::class, 'index'])->name('eleves.completeProfileForm');
Route::post('eleves/complete-profile', [ElevesController::class, 'store'])->name('eleves.completeProfile');
// route pour effectuer les inscripption 

Route::get('eleves/pay-inscription', [PaymentController::class, 'redirectToPayment'])->name('eleves.payInscription');
Route::get('payment/success', function() {
    return 'Paiement réussi !';
})->name('payment.success');

// route apres le payment sur paydunya
Route::get('payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
