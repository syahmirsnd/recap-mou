<?php

namespace App\Livewire\User\Mou;

use Livewire\Component;
use App\Models\Recap;

class MouList extends Component
{
    public function render()
    {
        return view('livewire.user.mou.mou-list',[
            'recaps' => Recap::all(),
        ]);
    }
}
