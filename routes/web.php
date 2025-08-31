<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\CommissionController;
use App\Models\Artwork;

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
    $artworks = \App\Models\Artwork::with('user')->latest()->take(8)->get();
    return view('welcome', compact('artworks'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Artwork routes
Route::get('/artworks/create', [ArtworkController::class, 'create'])->name('artworks.create');
Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
Route::get('/gallery', [ArtworkController::class, 'index'])->name('gallery');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::post('/artworks/{artwork}/like', [ArtworkController::class, 'like'])->name('artworks.like');
Route::post('/artworks/{artwork}/favorite', [ArtworkController::class, 'favorite'])->name('artworks.favorite');

// Work Experience Routes
Route::middleware('auth')->group(function () {
    Route::post('/work-experience', [WorkExperienceController::class, 'store'])->name('work-experience.store');
    Route::put('/work-experience/{workExperience}', [WorkExperienceController::class, 'update'])->name('work-experience.update');
    Route::delete('/work-experience/{workExperience}', [WorkExperienceController::class, 'destroy'])->name('work-experience.destroy');
});

// Comment routes
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Artist browsing routes
Route::get('/artists', [App\Http\Controllers\ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{artist}', [App\Http\Controllers\ArtistController::class, 'show'])->name('artists.show');

// Commission routes
Route::middleware('auth')->group(function () {
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('/commissions/inbox', [CommissionController::class, 'inbox'])->name('commissions.inbox');
    Route::get('/commissions/sent', [CommissionController::class, 'sent'])->name('commissions.sent');
    Route::get('/commissions/create/{artist}', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('/commissions/{artist}', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('/commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');
    Route::post('/commissions/{commission}/accept', [CommissionController::class, 'accept'])->name('commissions.accept');
    Route::post('/commissions/{commission}/reject', [CommissionController::class, 'reject'])->name('commissions.reject');
    Route::post('/commissions/{commission}/start-work', [CommissionController::class, 'startWork'])->name('commissions.start-work');
    Route::post('/commissions/{commission}/complete', [CommissionController::class, 'complete'])->name('commissions.complete');
    Route::post('/commissions/{commission}/confirm-completion', [CommissionController::class, 'confirmCompletion'])->name('commissions.confirm-completion');
    Route::post('/commissions/{commission}/cancel', [CommissionController::class, 'cancel'])->name('commissions.cancel');
});

// Add register route directly to ensure it's accessible
Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

require __DIR__.'/auth.php';
