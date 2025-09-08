<?php

use App\Livewire\Shep\ShepDashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Shep\Mou\MouList as ShepMouList;
use App\Livewire\Shep\Mou\AddMou;
use App\Livewire\Shep\Mou\EditMou;
use App\Livewire\User\Mou\MouList as UserMouList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'user'])
    ->name('user.dashboard');

// USER route
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/mou-list', UserMouList::class)->name('user.mou.index');
});

// SHEP route
Route::middleware(['auth', 'shep'])->group(function () {
    Route::get('/shep/mou-list', ShepMouList::class)->name('shep.mou.index');
});
Route::get('/create/mou', AddMou::class)->name('mou.create');
Route::get('/edit/mou/{id}', EditMou::class)->name('mou.edit');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['shep','auth'])->group(function(){
    Route::get('/shep/dashboard', ShepDashboard::class)->name('shep.dashboard');
});

require __DIR__.'/auth.php';
