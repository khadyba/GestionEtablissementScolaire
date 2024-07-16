<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ElevesController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ElevesCoursController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\SalleDeClasseController;
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
    Route::post('logout', [UsersController::class, 'logout'])->name('logout');
    Route::post('login', [UsersController::class, 'LoginForm'])->name('login.submit')->middleware('checkProfileCompletion');
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
    Route::get('/admin/dashboard', [AdministrateurController::class, 'index'])->name('admin.dashboard');
    Route::post('/etablissement/creer', [EtablissementController::class, 'store'])->name('etablissements.store');
    Route::get('/etablissement/formulaire', [EtablissementController::class, 'create'])->name('etablissement.formulaire');
    Route::get('/admin/profile/edit', [AdministrateurController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile/update', [AdministrateurController::class, 'update'])->name('admin.profile.update');
    Route::get('/classes/create', [ClasseController::class, 'create'])->name('classes.create');
    Route::post('/classes', [ClasseController::class, 'store'])->name('classes.store');
    Route::get('/listDesClasses',[ClasseController::class,'index'])->name('classes.index');
    Route::get('/classes/{id}', [ClasseController::class, 'show'])->name('classes.show');
    Route::get('/classes/{id}/edit',[ClasseController::class,'edit'])->name('classes.edit');
    Route::put('/classes/{id}/update',[ClasseController::class,'update'])->name('classes.update');
    Route::delete('/classes/{id}',[ClasseController::class,'destroy'])->name('classes.destroy');
    // route pour creer les salle de classe
    Route::get('/admin/salles/create', [SalleDeClasseController::class, 'create'])->name('admin.salles.create');
    Route::post('/admin/salles/store', [SalleDeClasseController::class, 'store'])->name('admin.salles.store');
    Route::get('/admin/salles-de-classe', [SalleDeClasseController::class, 'index'])->name('admin.salles-de-classe.index');
    Route::get('/admin/sallesclasse/{id}/edit', [SalleDeClasseController::class, 'edit'])->name('admin.salles-de-classe.edit');
    Route::post('/admin/sallesclasse/{id}', [SalleDeClasseController::class, 'update'])->name('admin.salles-de-classe.update');
    Route::delete('/admin/sallesclasse/{id}', [SalleDeClasseController::class, 'destroy'])->name('admin.salles-de-classe.destroy');
    // route pour les affectations
    Route::get('/classes/{id}/eleves', [ClasseController::class, 'assignStudents'])->name('classes.assign.students');
    Route::get('/admin/eleves-inscrits', [AdministrateurController::class, 'listeElevesInscrits'])->name('admin.eleves.inscrits');
    Route::post('assign-eleves/{id}', [ClasseController::class, 'storeAssignedStudents'])->name('assign.eleves.store');
    Route::get('/classes/{id}/professeurs', [ClasseController::class, 'assignTeachers'])->name('classes.assign.teachers');
    Route::post('/classes/{id}/professeurs', [ClasseController::class, 'storeAssignedTeacher'])->name('classes.assign.teachers.store');
    Route::delete('/classes/{classeId}/professeurs/{professeurId}', [ClasseController::class, 'detachProfesseurFromClasse'])->name('classes.professeurs.detach');
    Route::get('/classes/{classeId}/professeurs/manage', [ClasseController::class, 'manageProfessors'])->name('classes.professeurs.manage');
    // route pour la gestion des emplois du temps
    Route::get('/emplois_du_temps', [EmploisDuTempsController::class, 'index'])->name('emplois_du_temps.index');
    Route::get('/emplois_du_temps/create/{classe}', [EmploisDuTempsController::class, 'create'])->name('emplois_du_temps.create');
    Route::post('/emplois_du_temps/store/{classe}', [EmploisDuTempsController::class, 'store'])->name('emplois_du_temps.store');
    Route::get('/emplois-du-temps/{id}/download', [EmploisDuTempsController::class, 'download'])->name('emplois_du_temps.download');
    // route pour l'ajout des professeur 
    Route::get('/listProfAjouter',[AdministrateurController::class,'index'])->name('list.index');
    Route::get('/formulairAjout',[AdministrateurController::class,'formulaire'])->name('affiche.formulaire');
    Route::post('/AjouterProf',[AdministrateurController::class,'ajouterProfesseur'])->name('Ajout.ajouterProfesseur');
    
});
Route::middleware(['auth', 'checkProfileCompletion'])->group(function () {  
            // route pour les professeurs
            Route::prefix('professeurs')->name('professeurs.')->group(function () {
                Route::get('/professeurs/complete-profil', [ProfesseurController::class, 'showCompleteProfileForm'])->name('professeurs.complete-profile');
                Route::post('/professeurs/complete-profil', [ProfesseurController::class, 'completeProfile'])->name('professeurs.complete-profile.store');
                Route::get('/prof/dashboard', [ProfesseurController::class, 'index'])->name('prof.dashboard');
                Route::get('/listDesClasses', [ProfesseurController::class, 'index'])->name('classes.index.prof');
                Route::get('/classes/{id}', [ProfesseurController::class, 'show'])->name('classes.show.prof');
                Route::get('/cours/create/{classe}', [ProfesseurController::class, 'create'])->name('cours.create');
                Route::post('/cours', [ProfesseurController::class, 'store'])->name('cours.store');
                Route::get('/cours', [ProfesseurController::class, 'listeCours'])->name('cours.list.prof');
                Route::get('/cours/{id}', [ProfesseurController::class, 'detailCours'])->name('cours.detail.prof');
                Route::get('/cours/{id}/edit', [ProfesseurController::class, 'edit'])->name('cours.edit');
                Route::put('/cours/{id}', [ProfesseurController::class, 'update'])->name('cours.update');
                Route::delete('/cours/{id}', [ProfesseurController::class, 'destroy'])->name('cours.destroy');
                Route::get('/salles/salleDisponible/{id}', [SalleDeClasseController::class, 'afficherSallesDisponibles'])->name('salle.disponible');
                Route::post('/cours/{coursId}/assign-salle/{salleId}', [SalleDeClasseController::class, 'assignSalle'])->name('cours.assignSalle');
                Route::get('/cours/download/{id}', [ProfesseurController::class, 'download'])->name('cours.download');
            });
            // Routes pour les élèves
            Route::prefix('eleves')->name('eleves.')->group(function () {
                Route::get('/eleve/dashboard', [ElevesController::class, 'index'])->name('eleve.dashboard');
                Route::get('/cours', [ElevesController::class, 'index'])->name('cours.index');
                Route::get('/cours/{id}', [ElevesController::class, 'show'])->name('cours.show.eleve');
                Route::get('/cours/download/{id}', [ProfesseurController::class, 'download'])->name('cours.download');
                Route::get('/classes', [ElevesCoursController::class, 'index'])->name('classes.index');
                Route::get('/classes/{id}', [ElevesCoursController::class, 'show'])->name('classes.detail');
                Route::get('/classes/{id}/cours',  [ElevesCoursController::class, 'listCours'])->name('cours.index');
                Route::get('/cours/{id}',  [ElevesCoursController::class, 'detailCours'])->name('cours.detail');
                Route::get('eleves/complete-profile', [ElevesController::class, 'completerProfil'])->name('eleves.completeProfileForm');
                Route::post('eleves/complete-profile', [ElevesController::class, 'store'])->name('eleves.completeProfile');
                Route::get('eleves/pay-inscription', [PaymentController::class, 'redirectToPayment'])->name('eleves.payInscription');
            }); 
            // route pour les parents 
            Route::prefix('parents')->name('parents.')->group(function (){
                Route::get('/parent/dashboard', [ParentsController::class, 'index'])->name('parent.dashboard');
                Route::get('parents/complete-profile', [ParentsController::class, 'completerProfil'])->name('parent.completeProfileForm');
                Route::post('parents/complete-profile', [ParentsController::class, 'store'])->name('parent.completeProfile');
            });
});
  
       
 // route apres le payment sur paydunya
 Route::get('payment/success', [PaymentController::class, 'success'])->name('payment.success');
 Route::get('payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
 Route::post('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');