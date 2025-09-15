<?php

namespace App\Livewire\Shep\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Masmerise\Toaster\Toaster;

class EditUser extends Component
{
    public  $name = '';
    public  $email = '';
    public  $role = '';
    public  $shep_verified = '';
    public  $user_details = '';

    public function mount($id){
        $this->user_details = \App\Models\User::find($id);

        $this->fill ([
            'name' =>$this->user_details->name,
            'email' =>$this->user_details->email,
            'role' =>$this->user_details->role,
            'shep_verified' =>$this->user_details->shep_verified,
        ]);
    }

    public function update()
    {
        $validated = $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $this->user_details->id,
            'role'  => 'required',
            'shep_verified'  => 'required',
        ]);

        $this->user_details->update($validated);

        Toaster::success('Data user berhasil diperbarui.');

        return redirect()->route('shep.user.index');
    }

    
    public function render()
    {
        return view('livewire.shep.user.edit-user');
    }
}
