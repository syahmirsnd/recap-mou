<?php

namespace App\Livewire\Shep\Mou;

use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
#[Title('CCO Recap MOU | Tambah MoU')]

class AddMou extends Component
{
    public $maindealers = [];
    public $schools_id = [];
    public $maindealer_id = '';
    public $school_id = '';
    public $status_dokumen = '';
    public $keterangan = '';

    public function save(){
        $this->validate([
            'maindealer_id' => 'required',
            'school_id' => 'required',
            'status_dokumen' => 'required',
            'keterangan' => 'string',
        ]);

        \App\Models\Recap::create([
            'main_dealer_id' => $this->maindealer_id,
            'school_id' => $this->school_id,
            'status_dokumen' => $this->status_dokumen,
            'keterangan' => $this->keterangan,
        ]);

        $this ->reset();

        Toaster::success('Data MoU Berhasil Ditambahkan');

        return redirect()->route('shep.mou.index');
    }

    public function mount(){
        $this->maindealers = \App\Models\MainDealer::all();
        $this->schools_id = \App\Models\School::all();  
    }
    public function render()
    {
        return view('livewire.shep.mou.add-mou');
    }
}
