<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kopstuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'ur_kopstuk',
        'kd_ktm',
        'kd_smk',
    ];

    public function kotama()
    {
        return $this->belongsTo(Kotama::class, 'kd_ktm', 'kd_ktm');
    }

    public function satminkal()
    {
        return $this->belongsTo(Satminkal::class, 'kd_smk', 'kd_smk')
                    ->where('kd_ktm', $this->kd_ktm);
    }
}
