<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SuratMasuk extends Model
{
    
    use HasUuids;
    use HasFactory;   
    protected $guarded= [];

    public function klasifikasiSurat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); // Corrected the foreign key
    }
    public function sifat()
    {
        return $this->belongsTo(Sifat::class, 'sifat_id'); // Corrected the foreign key
    }  
    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }
    public function lemari()
    {
        return $this->belongsTo(Lemari::class, 'lemari_id');
    }

    public function loker()
    {
        return $this->belongsTo(Loker::class, 'loker_id');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }
    protected $casts = [
        'lampiran_surat_masuk' => 'array',
    ];
 
}
