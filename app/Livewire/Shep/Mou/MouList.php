<?php

namespace App\Livewire\Shep\Mou;

use Livewire\Component;
use App\Models\Recap;
use Masmerise\Toaster\Toaster;

class MouList extends Component
{
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
