<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DisposisiSuratKeluar extends Model
{
    use HasUuids;
    use HasFactory;
    protected $guarded = [];

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    
}
