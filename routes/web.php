<?php

use App\Livewire\Shep\ShepDashboard;
use App\Livewire\User\UserDashboard;
use App\Livewire\User\AboutProgram;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Shep\Mou\MouList as ShepMouList;
use App\Livewire\Shep\Mou\AddMou;
use App\Livewire\Shep\Mou\EditMou;
use App\Livewire\Shep\User\UserList;
use App\Livewire\Shep\User\AddUser;
use App\Livewire\Shep\User\EditUser;
use App\Livewire\Shep\Maindealer\MDList;
use App\Livewire\Shep\Maindealer\AddMD;
use App\Livewire\Shep\Maindealer\EditMD;
use App\Livewire\Shep\School\SchoolList;
use App\Livewire\Shep\School\AddSchool;
use App\Livewire\Shep\School\EditSchool;
use App\Livewire\User\Mou\MouList as UserMouList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// USER route
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/dashboard', UserDashboard::class)->name('user.dashboard');
    Route::get('/mou-list', UserMouList::class)->name('user.mou.index');
});

// SHEP route
Route::middleware(['auth', 'shep'])->group(function () {
    Route::get('/shep/mou-list', ShepMouList::class)->name('shep.mou.index');
});
Route::get('/create/mou', AddMou::class)->name('mou.create');
Route::get('/edit/mou/{id}', EditMou::class)->name('mou.edit');

Route::get('/shep/user-list', UserList::class)->name('shep.user.index');
Route::get('/create/user', AddUser::class)->name('user.create');
Route::get('/edit/user/{id}', EditUser::class)->name('user.edit');

Route::get('/shep/maindealer-list', MDList::class)->name('shep.maindealer.index');
Route::get('/create/maindealer', AddMD::class)->name('maindealer.create');
Route::get('/edit/maindealer/{id}', EditMD::class)->name('maindealer.edit');

Route::get('/shep/school-list', SchoolList::class)->name('shep.school.index');
Route::get('/create/school', AddSchool::class)->name('school.create');
Route::get('/edit/school/{id}', EditSchool::class)->name('school.edit');

Route::get('/about', AboutProgram::class)->name('about.index');


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
