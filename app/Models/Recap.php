<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recap extends Model
{
    protected $fillable = [
        'nomor_surat',
        'status_dokumen',
        'main_dealer_id',
        'school_id',
        'keterangan',
    ];

    public function mainDealer()
    {
        return $this->belongsTo(MainDealer::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
