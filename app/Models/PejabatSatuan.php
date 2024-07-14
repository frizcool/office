<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PejabatSatuan extends Model
{
    use HasFactory; use HasFactory;

    protected $fillable = [
        'nama_pejabat',
        'level',
        'kd_ktm',
        'kd_smk',
    ];

    public function kotama()
    {
        return $this->belongsTo(Kotama::class, 'kd_ktm', 'kd_ktm');
    }

    public function satminkal()
    {
        return $this->belongsTo(Satminkal::class, 'kd_smk', 'kd_smk');
    }
}
