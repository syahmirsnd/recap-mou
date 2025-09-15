<?php

namespace App\Livewire\Shep\User;

use Livewire\Component;
use App\Models\User;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;

class UserList extends Component
{
    #[On('deleteUser')]
    public function delete($id){
        $user = User::find($id);

        if (! $user) {
            Toaster::error('User tidak ditemukan.');
            return redirect()->route('shep.user.index');
        }

        // cek email spesifik
        if ($user->email === 'akunshep@undeleted.com') {
            return redirect()->route('shep.user.index');
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Tidak Bisa Dihapus',
                'text' => 'Akun ini tidak boleh dihapus!'
            ]);
            
        }

        $user->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data pengguna berhasil dihapus!'
        ]);
        Toaster::success('Data pengguna berhasil dihapus.');
        return redirect()->route('shep.user.index');
    }

    public function render()
    {
        return view('livewire.shep.user.user-list',[
            'users' => User::all(),
        ]);
        
    }
}