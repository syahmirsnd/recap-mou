<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MainDealer extends Model
{
    /** @use HasFactory <\Database\Factories\MainDealerFactory> */
    use HasFactory;

    protected $fillable = [
        'md_code',
        'md_name',
    ];

    public function schools()
    {
        return $this->hasMany(School::class, 'main_dealer_id');
    }

    public function recaps()
    {
        return $this->hasMany(Recap::class, 'main_dealer_id');
    }

    public function getJumlahSmkAttribute()
    {
        return $this->schools()->count();
    }

    public function getDiarsipkanAttribute()
    {
        return $this->recaps()
        ->where('status_dokumen', 'Di Arsip')
        ->count();
    }

    protected function kurang(): Attribute
    {
        return Attribute::get(fn () => max(0, $this->jumlah_smk - $this->diarsipkan));
    }

    protected function persen(): Attribute
    {
        return Attribute::get(function () {
            if ($this->jumlah_smk == 0) {
                return 0;
            }
            return round(($this->diarsipkan / $this->jumlah_smk) * 100, 2);
        });
    }

    protected function stat(): Attribute
    {
        return Attribute::get(fn () => $this->persen == 100 ? 'Lengkap' : 'Tidak Lengkap');
    }
}
