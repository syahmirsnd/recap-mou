<?php

namespace App\Livewire\Shep\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Masmerise\Toaster\Toaster;

class AddUser extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';

    public function save(){
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $validated['shep_verified'] = $validated['role'] === 'shep' ? 'yes' : 'no';

        User::create($validated);

        Toaster::success('Data Pengguna Berhasil Ditambahkan');

        return redirect()->route('shep.user.index');
    }

    public function render()
    {
        return view('livewire.shep.user.add-user');
    }
}
