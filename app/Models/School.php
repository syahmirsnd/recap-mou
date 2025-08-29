<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    /** @use HasFactory <\Database\Factories\SchoolFactory> */
    use HasFactory;

    protected $fillable = [
        'npsn',
        'school_name',
        'main_dealer_id',
    ];

    public function mainDealer(){
        return $this->belongsTo(MainDealer::class);
    }

}
