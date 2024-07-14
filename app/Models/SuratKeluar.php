<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_agenda',
        'tanggal_masuk',
        'kepada',
        'perihal',
        'klasifikasi_id',
        'lokasi_fisik',
        'lampiran_surat_masuk',
        'status',
    ];

    public function klasifikasiSurat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_id');
    }
}
