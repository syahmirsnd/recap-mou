<?php

namespace App\Livewire\Shep\Maindealer;

use Livewire\Component;
use App\Models\MainDealer;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;


class MdList extends Component
{
    #[On('deleteMD')]
    public function delete($id){
        MainDealer::find($id)->delete();
        Toaster::success('Data Main Dealer Berhasil Dihapus');
        return redirect()->route('shep.maindealer.index');
    }

    public function render()
    {
        return view('livewire.shep.maindealer.md-list',[
            'mds' => MainDealer::all(),
        ]);
        
    }
}