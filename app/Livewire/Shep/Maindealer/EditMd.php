<?php

namespace App\Livewire\Shep\Maindealer;

use Livewire\Component;
use App\Models\MainDealer;
use Masmerise\Toaster\Toaster;

class EditMd extends Component
{
    public  $md_name = '';
    public  $md_code = '';
    public  $md_details = '';
    
    public function mount($id){
        $this->md_details = \App\Models\MainDealer::find($id);

        $this->fill ([
            'md_code' =>$this->md_details->md_code,
            'md_name' =>$this->md_details->md_name,
        ]);
    }

    public function update()
    {
        $validated = $this->validate([
            'md_code' => 'required|string|max:255|unique:'.MainDealer::class.',md_code' . $this->md_details->id,
            'md_name' => 'required|string|max:255|unique:'.MainDealer::class.',md_name' . $this->md_details->id,
        ]);

        $this->md_details->update($validated);

        Toaster::success('Data main dealer berhasil diperbarui.');

        return redirect()->route('shep.maindealer.index');
    }

    public function render()
    {
        return view('livewire.shep.maindealer.edit-md');
    }
}
