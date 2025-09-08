<?php

namespace App\Livewire\Shep\Mou;

use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
#[Title('CCO Recap MOU | Edit MoU')]

class EditMou extends Component
{
    public $maindealers = [];
    public $schools_id = [];
    public $nomorsurat ='';
    public $maindealer_id = '';
    public $school_id = '';
    public $status_dokumen = '';
    public $keterangan = '';
    public $mou_details = '';

    public function mount($id){
        $this->mou_details = \App\Models\Recap::find($id);

        $this->fill([
            'nomorsurat' => $this->mou_details->nomor_surat,
            'maindealer_id' => $this->mou_details->main_dealer_id,
            'school_id' => $this->mou_details->school_id,
            'status_dokumen' => $this->mou_details->status_dokumen,
            'keterangan' => $this->mou_details->keterangan,
        ]);

        $this->maindealers = \App\Models\MainDealer::all();
        $this->schools_id = \App\Models\School::all();  
    }

    public function update(){
        $this->validate([
            'nomorsurat' => 'required|integer',
            'maindealer_id' => 'required',
            'school_id' => 'required',
            'status_dokumen' => 'required',
            'keterangan' => 'string',
        ]);

        \App\Models\Recap::find($this->mou_details->id)->update([
            'nomor_surat' => $this->nomorsurat,
            'main_dealer_id' => $this->maindealer_id,
            'school_id' => $this->school_id,
            'status_dokumen' => $this->status_dokumen,
            'keterangan' => $this->keterangan,
        ]);

        Toaster::success('Data MoU Berhasil Diperbarui');
        return redirect()->route('shep.mou.index');
    }

    public function render()
    {
        return view('livewire.shep.mou.edit-mou');
    }
}
