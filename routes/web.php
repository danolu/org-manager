<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VoteController;

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Profile\Edit as ProfileEdit;
use App\Http\Livewire\Profile\ChangePassword;
use App\Http\Livewire\Vote\Index as VoteIndex;
use App\Http\Livewire\Vote\Position as VotePosition;
use App\Http\Livewire\Vote\Results as VoteResults;
use App\Http\Livewire\Vote\PositionResults;
use App\Http\Livewire\Candidates\Index as CandidatesIndex;
use App\Http\Livewire\Candidates\Form as CandidatesForm;
use App\Http\Livewire\Positions\Index as PositionsIndex;
use App\Http\Livewire\Positions\Form as PositionsForm;
use App\Http\Livewire\Settings\Index as SettingsIndex;
use App\Http\Livewire\Voters\Index as VotersIndex;
use App\Http\Livewire\Voters\Form as VotersForm;
use App\Http\Livewire\Voters\Show as VotersShow;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'requestLink'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::any('/voters', [VoteController::class, 'voters']); // ✅ intentional? You kept it.

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', [VerificationController::class, 'index'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::get('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/edit-profile', ProfileEdit::class)->name('user.edit');
    Route::any('/verify/{email}/{id}', [UserController::class, 'verify'])->name('user.verify');
    Route::any('/verify/resend', [UserController::class, 'resendverify'])->name('resend.verify');

    Route::any('/members', [VoteController::class, 'members']);

    // Voting
    Route::get('/vote', VoteIndex::class)->name('vote');
    Route::get('/vote/{position}', VotePosition::class)->name('vote.position');

    // Results
    Route::get('/results', VoteResults::class)->name('results');
    Route::get('/results/{position}', PositionResults::class)->name('results.position');

    // Candidates
    Route::get('/candidates', CandidatesIndex::class)->name('candidates.index');
    Route::get('/candidates/create', CandidatesForm::class)->name('candidates.create');
    Route::get('/candidates/{candidate}/edit', CandidatesForm::class)->name('candidates.edit');

    // Positions
    Route::get('/positions', PositionsIndex::class)->name('positions.index');
    Route::get('/positions/create', PositionsForm::class)->name('positions.create');
    Route::get('/positions/{position}/edit', PositionsForm::class)->name('positions.edit');

    // Categories Controller
    Route::resource('categories', CategoryController::class);

    // Settings
    Route::get('/settings', SettingsIndex::class)->name('settings.index');

    // Voters (Livewire)
    Route::get('/voters', VotersIndex::class)->name('voters.index');
    Route::get('/voters/create', VotersForm::class)->name('voters.create');
    Route::get('/voters/{user}', VotersShow::class)->name('voters.show');
    Route::get('/voters/{user}/edit', VotersForm::class)->name('voters.edit');

    // Password
    Route::get('/change-password', ChangePassword::class)->name('password.change');

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});