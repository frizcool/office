<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluarInternal extends Model
{
    use HasFactory; 

    protected $fillable = [
        'surat_keluar_id',
        'isi_disposisi',
        'status',
        'pejabat_satuan_id',
    ];

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }

    public function pejabatSatuan()
    {
        return $this->belongsTo(PejabatSatuan::class, 'pejabat_satuan_id');
    }
}
