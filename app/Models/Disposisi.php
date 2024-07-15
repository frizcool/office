<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Disposisi extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'surat_masuk_id',
        'disposisi_kepada',
        'isi',
        'catatan',
        'paraf',
        'tanggal_disposisi',
        'user_id',
        'disposisi_list_id',
    ];
    protected $casts = [
        'disposisi_kepada' => 'array',
        'disposisi_list_id' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }
  

    public function getPenerimaDisposisiAttribute()
    {
        return User::whereIn('id', $this->disposisi_kepada)->pluck('jabatan');
    }

    public function disposisiList()
    {
        return $this->belongsTo(DisposisiList::class, 'disposisi_list_id');
    }

    

    
}
