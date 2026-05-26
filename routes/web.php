<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberCardController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/actualites', [PostController::class, 'index'])->name('posts.index');
Route::get('/actualites/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/evenements', [EventController::class, 'index'])->name('events.index');
Route::get('/evenements/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/opportunites', [OpportunityController::class, 'index'])->name('opportunities.index');

Route::get('/ressources', [ResourceController::class, 'index'])->name('resources.index');

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [AuthController::class, 'login']);

    Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register']);
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Espace membre (authentifié)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/mon-espace', [MemberDashboardController::class, 'index'])->name('membre.dashboard');
    Route::get('/membre/{member}/carte/pdf', [MemberCardController::class, 'pdf'])->name('member.card.pdf');

    // Cotisation CinetPay
    Route::post('/mon-espace/cotiser', [SubscriptionController::class, 'initiate'])->name('subscription.initiate');
    Route::get('/paiement/retour', [SubscriptionController::class, 'return'])->name('payment.return');
});

// Webhook CinetPay — sans CSRF (vient du serveur CinetPay)
Route::post('/paiement/notify', [SubscriptionController::class, 'notify'])
    ->name('payment.notify')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
