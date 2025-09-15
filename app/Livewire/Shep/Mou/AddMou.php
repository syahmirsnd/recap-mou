<?php

namespace App\Livewire\Shep\Mou;

use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\School;
use App\Models\Recap;

#[Title('CCO Recap MOU | Tambah MoU')]
class AddMou extends Component
{
    public $schools_id = [];
    public $nomorsurat = '';
    public $school_id = '';
    public $status_dokumen = '';
    public $keterangan = '';

    public function mount(){
        $this->schools_id = School::orderBy('school_name', 'asc')->get();;
    }

    public function save(){
        $this->validate([
            'nomorsurat' => 'required|integer|unique:recaps,nomor_surat',
            'school_id' => 'required|unique:recaps,school_id',
            'status_dokumen' => 'required',
            'keterangan' => 'string|nullable',
        ]);

        $school = School::findOrFail($this->school_id);
        
        Recap::create([
            'nomor_surat' => $this->nomorsurat,
            'main_dealer_id' => $school->main_dealer_id,
            'school_id' => $this->school_id,
            'status_dokumen' => $this->status_dokumen,
            'keterangan' => $this->keterangan,
        ]);

        $this->reset();

        Toaster::success('Data MoU Berhasil Ditambahkan');
        return redirect()->route('shep.mou.index');
    }

    public function render()
    {
        return view('livewire.shep.mou.add-mou');
    }
}
