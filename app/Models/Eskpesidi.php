<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eskpesidi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_ktm',
        'kd_smk',
        'surat_keluar_id',
        'tanggal_distribusi',
        'penerima',
        'tanggal_diterima',
        'paraf',
    ];

    public function kotama()
    {
        return $this->belongsTo(Kotama::class, 'kd_ktm', 'kd_ktm');
    }

    public function satminkal()
    {
        return $this->belongsTo(Satminkal::class, 'kd_smk', 'kd_smk');
    }

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }
}
