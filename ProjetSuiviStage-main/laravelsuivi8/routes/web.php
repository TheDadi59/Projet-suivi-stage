<?php

use App\Http\Controllers\Suivi\ListeStagesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ListeStagesController::class, 'listeStages']);

Route::get('/liste-stages-dp', [ListeStagesController::class, 'listeStagesDP']);


Route::get('/activite/{id}', [\App\Http\Controllers\Suivi\ActiviteController::class, 'detailActivite'])->name('activite');




Route::post('/activite', [ListeStagesController::class, 'changementEtat'])->name('changementEtat');

Route::post('/cloture', [ListeStagesController::class, 'cloture'])->name('changementEtat');

/*
 * Routes API
 */
Route::get('/api/activites/{idTemplateParent}', [\App\Http\Controllers\Suivi\APIController::class, 'getListeActivite'])->name('getListeActivite');
Route::post("/api/activitie/jalon/valider", [\App\Http\Controllers\Suivi\APIController::class, 'postValiderJalon'])->name("post-valider-jalon");
