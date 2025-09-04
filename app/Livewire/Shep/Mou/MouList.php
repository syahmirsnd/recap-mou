<?php

namespace App\Livewire\Shep\Mou;

use Livewire\Component;
use App\Models\Recap;

class MouList extends Component
{
    public function render()
    {
        return view('livewire.shep.mou.mou-list',[
            'recaps' => Recap::all(),
        ]);
        
    }
}
