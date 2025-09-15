<?php

namespace App\Livewire\Shep\Maindealer;

use Livewire\Component;
use App\Models\MainDealer;
use Masmerise\Toaster\Toaster;

class AddMd extends Component
{
    public string $md_code = '';
    public string $md_name = '';

    public function save(){
        $validated = $this->validate([
            'md_code' => 'required|string|max:255|unique:'.MainDealer::class.',md_code',
            'md_name' => 'required|string|max:255|unique:'.MainDealer::class.',md_name',
        ]);

        MainDealer::create($validated);

        Toaster::success('Data Main Dealer Berhasil Ditambahkan');

        return redirect()->route('shep.maindealer.index');
    }

    public function render()
    {
        return view('livewire.shep.maindealer.add-md');
    }
}
