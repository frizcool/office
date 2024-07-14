<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiSurat extends Model
{
    use HasFactory;
    protected $fillable = [
        'ur_klasifikasi',
    ];
}
