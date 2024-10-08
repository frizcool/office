<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SuratKeluar extends Model
{
    use HasUuids;
    use HasFactory;

    protected $guarded = [];

    public function klasifikasiSurat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_id');
    }

    public function disposisi_surat_keluars()
    {
        return $this->hasMany(DisposisiSuratKeluar::class);
    }

    // Mendapatkan disposisi terbaru dari relasi
    public function latestDisposisi()
    {
        return $this->disposisi_surat_keluars()->latest('created_at')->first();
    }

    // Mendapatkan status disposisi terbaru
    public function getLatestDisposisiStatusAttribute()
    {
        $latestDisposisi = $this->latestDisposisi();
        return $latestDisposisi ? $latestDisposisi->status : 'Belum Disposisi';
    }

    // Mendapatkan nama pengesah disposisi terbaru
    public function getLatestDisposisiApproverNameAttribute()
    {
        $latestDisposisi = $this->latestDisposisi();
        return $latestDisposisi && $latestDisposisi->user ? $latestDisposisi->user->name : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $casts = [
        'lampiran_surat_keluar' => 'array',
    ];
}
