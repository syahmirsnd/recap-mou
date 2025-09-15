<?php

namespace App\Livewire\Shep\School;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\School;

class AddSchool extends Component
{
    public $maindealers = [];
    public $maindealer_id = '';
    public $npsn = '';
    public $school_name = '';

    public function save(){
        $this->validate([
            'npsn' => 'required|digits:10|integer|unique:schools,npsn',
            'school_name' => 'required|string|unique:schools,school_name',
            'maindealer_id' => 'required',
        ]);

        \App\Models\School::create([
            'npsn' => $this->npsn,
            'school_name' => $this->school_name,
            'main_dealer_id' => $this->maindealer_id,
        ]);

        $this ->reset();

        Toaster::success('Data SMK Berhasil Ditambahkan');

        return redirect()->route('shep.school.index');
    }

    public function mount(){
        $this->maindealers = \App\Models\MainDealer::orderBy('md_name', 'asc')->get();;
    }

    public function render()
    {
        return view('livewire.shep.school.add-school');

    }


}
