<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Rak extends Model
{
    use HasFactory, HasUuids;

    protected $guarded= [];
    public $incrementing = false;
}
