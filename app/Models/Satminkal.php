<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satminkal extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_ktm',
        'kd_smk',
        'ur_smk',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'kd_smk', 'kd_smk');
    }
    public function kotama()
    {
        return $this->belongsTo(Kotama::class, 'kd_ktm', 'kd_ktm');
    }
}
