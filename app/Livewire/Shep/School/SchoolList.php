<?php

namespace App\Livewire\Shep\School;

use Livewire\Component;
use App\Models\School;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;

class SchoolList extends Component
{
    #[On('deleteSMK')]
    public function delete($id){
        School::find($id)->delete();
        Toaster::success('Data SMK Berhasil Dihapus');
        return redirect()->route('shep.school.index');
    }

    public function render()
    {
        return view('livewire.shep.school.school-list',[
        'schools' => School::all()
        ,]);
    }
}
