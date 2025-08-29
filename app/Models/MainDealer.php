<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainDealer extends Model
{
    /** @use HasFactory <\Database\Factories\MainDealerFactory> */
    use HasFactory;

    protected $fillable = [
        'md_code',
        'md_name',
        'jumlah_smk',
        'diarsipkan',
        'kurangnya',
        'persentase',
        'status',
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
