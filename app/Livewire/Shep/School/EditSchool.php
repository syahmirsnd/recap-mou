<?php

namespace App\Livewire\Shep\School;

use Livewire\Component;
use App\Models\School;
use Masmerise\Toaster\Toaster;

class EditSchool extends Component
{
    public $maindealers = [];
    public $main_dealer_id = '';
    public $npsn = '';
    public $school_name = '';
    public $school_details = '';

    public function mount($id){
        $this->school_details = \App\Models\School::find($id);
        $this->maindealers = \App\Models\MainDealer::orderBy('md_name', 'asc')->get();

        $this->fill ([
            'npsn' =>$this->school_details->npsn,
            'school_name' =>$this->school_details->school_name,
            'main_dealer_id' =>$this->school_details->main_dealer_id,
        ]);

    }

    public function update(){
        $validated = $this->validate([
            'npsn' => 'required|digits:10|integer|unique:schools,npsn,' . $this->school_details->id,
            'school_name' => 'required|string|unique:schools,school_name,'. $this->school_details->id,
            'main_dealer_id' => 'required',
        ]);

        $this->school_details->update($validated);

        Toaster::success('Data SMK Berhasil Ditambahkan');

        return redirect()->route('shep.school.index');
    }


    public function render()
    {
        return view('livewire.shep.school.edit-school');
    }
}
