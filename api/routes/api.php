<?php

use App\Http\Controllers\AdminActiviteeController;
use App\Http\Controllers\AdminActiviteeOffreController;
use App\Http\Controllers\AdminDemandeController;
use App\Http\Controllers\AdminHoraireController;
use App\Http\Controllers\AdminOffreController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AnimatorController;
use App\Http\Controllers\Authentication\EmailVerificationController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\Authentication\ResetPasswordCntroller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentDemandeController;
use App\Http\Controllers\ParentFactureController;
use App\Http\Controllers\showController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register-parent', [RegistrationController::class,'RegisterParent'])
    ->name('Enregistrement')
    ->middleware('recaptcha');

Route::get('verify-email/{token}', [EmailVerificationController::class,'verifyemail'])
    ->name('verify');

Route::post('login', [LoginController::class,'login'])->name('login');
Route::post('forget-password', [ResetPasswordCntroller::class,'RessetPasswordEmail'])
    ->name('forgetPassword');
Route::post('reset-password/{token}', [ResetPasswordCntroller::class,'ResetPassword'])
    ->name('restpassword');



// ici tous les choses isi l'authetification est nececiare
Route::middleware(['auth:sanctum','recaptcha'])->group(function (){
    Route::get('my-profile', [LoginController::class,'AuthenticatedProflie'])->name('Myprofile');

// AdminController:
    // admin
    Route::post('register-admin', [RegistrationController::class,'RegisterAdmin'])->name('AjouterAdmin')->middleware('Check_Admin_User');// administarateur si ill va ajouter un sous admin
    Route::post('register-animateur', [RegistrationController::class,'RegisterAnimateur'])->name('AjouterAnimateur')->middleware('Check_Admin_User');
    Route::delete('/delete/parent/by/admin/{parent}',[AdminUserController::class,'deleteParent']);
    Route::delete('/delete/animateur/by/admin/{animateur}',[AdminUserController::class,'deleteAnimateur']);

    //offers managed by admin
    Route::post('/create/offer/',[AdminOffreController::class,'createOffer']);
    Route::put('/update/offer/{offer}/',[AdminOffreController::class,'updateOffer']);
    Route::delete('/delete/offer/{offer}',[AdminOffreController::class,'destroyOffer']);


    // activities ceated managed by admin
    Route::post('/create/activity/',[AdminActiviteeController::class,'createActivity']);
    Route::put('/update/activity/{activity}',[AdminActiviteeController::class,'updateActivity']);
    Route::delete('/delete/activity/{activity}',[AdminActiviteeController::class,'destroyActivity']);


    // offers activities seted by admin
    Route::post('/add/offer/activity/{offer}/{activity}',[AdminActiviteeOffreController::class,'addActivityToOffer']);
    Route::put('/update/offer/activity/{activityOffer}',[AdminActiviteeOffreController::class,'updateActivityInOffer']);
    Route::delete('/delete/offer/activity/{activityOffer}',[AdminActiviteeOffreController::class,'destroyActivity']);
    Route::post('/create/horaire/',[AdminHoraireController::class,'createHoraire']);
    Route::put('/update/horaire/',[AdminHoraireController::class,'updateHoraire']);
    Route::put('/update/horaire/',[AdminHoraireController::class,'deleteHoraire']);

    Route::put('/devis/update/{id}',[ ParentDemandeController::class,'UpdateDevis']);


    // parent
    Route::post('logout', [LogoutController::class,'logout'])->name('logout');
    Route::get('/show/parent/enfant/',[showController::class,'showEnfantOfParent']);
    Route::get('/show/enfant/planning/{enfant_id}',[ShowController::class,'showPlaningEnfant']);
    Route::get('/show/notification/parent/top/',[ShowController::class,'showTopParentNotifications']);
    Route::get('/show/notification/parent/remaining/',[ShowController::class,'showRemainingParentNotifications']);
    Route::get('/show/demandes/admin/',[showController::class, 'showDemandesOfAdmin']);
    Route::get('/show/offers/',[showController::class,'showOffers']);
    route::get('/show/parent/infos/',[ShowController::class,'showParentInfo']);



    // show demandes of parent
    Route::get('/show/demandes/parent/',[showController::class, 'showDemandesOfParent']);
    Route::get('/show/parent/demande/activities/{demande_id}',[ShowController::class,'showActivitiesInDemandeOfParent']);
    Route::get('/show/parent/demande/activity/enfants/{demande_id}/{activite_offre_id}',[ShowController::class,'showEnfantInActivityInDemandeOfParent']);
    Route::delete('/delete/notification/{notification}',[NotificationController::class,'deleteNotification']);
    Route::get('/delete/notification/all/',[NotificationController::class,'deleteAllUserNotifications']);
    Route::post('/create/demande/{pack?}',[ParentDemandeController::class,'storeDemande']);
    Route::put('/update/demande/inscription/{demande_id}/{activite_offre_id}/{enfant_id}',[AdminDemandeController::class,'gererDemande']);
    Route::get('/create/facture/',[ParentFactureController::class,'createFacture']);

//show
    Route::get('/show/offers/top/',[showController::class,'showTopOffers']);
    Route::get('/show/offers/remaining/',[showController::class,'showRemainingOffers']);
    Route::get('/show/offer/{offre}',[showController::class,'showOffer']);
    Route::get('/show/activities/',[showController::class,'showActivities']);
    Route::get('/show/offer/activities/{offer}',[showController::class, 'showActivitiesInOffer']);
    Route::get('/show/offer/activities/more/{offer}',[showController::class, 'showActivitiesOfferInOffer']);
    Route::get('/show/offer/activities/all/{offer}',[showController::class,'showActivitiesInOfferAllInfos']);
    Route::get('/show/offer/activity/horaires/{activite_id}',[showController::class,'showHoraireInActivity']);
    Route::get('/show/offer/activity/enfants/{activite_id}',[showController::class,'showEnfantInActivity']);

//animateurs
    Route::get('/show/animateurs/',[ShowController::class,'showAnimateurs']);
    Route::get('/show/animateur/{animateur}',[ShowController::class,'showAnimateur']);
    Route::get('/show/all/horaires/animateur/{anim_id?}',[ShowController::class,'showAllHoraireOfAnimateur']);
    Route::get('/show/busy/horaires/animateur/{anim_id?}',[ShowController::class,'showBusyHoraireOfAnimateurs']);
    Route::get('/show/available/horaires/animateur/{anim_id?}',[ShowController::class,'showAvailableHoraireOfAnimateurs']);
    Route::get('/show/new/horaires/animateur/{anim_id}',[ShowController::class,'showHoraireForAnimToAdd']);
    Route::post('/add/available/horaires/anim/',[AnimatorController::class,'addAvailableHour']);

});








