<?php

namespace App\Livewire\Shep\Mou;

use Livewire\Component;
use App\Models\Recap;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;

class MouList extends Component
{
    #[On('deleteRecap')]
    public function delete($id){
        Recap::find($id)->delete();
        Toaster::success('Data MoU Berhasil Dihapus');
        return redirect()->route('shep.mou.index');
    }

    public function render()
    {
        return view('livewire.shep.mou.mou-list',[
            'recaps' => Recap::all(),
        ]);
        
    }
}
