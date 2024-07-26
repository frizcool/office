<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable 
{
    use HasFactory, Notifiable,HasRoles,TwoFactorAuthenticatable;
    
    use HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'jabatan',
        'kd_ktm',
        'kd_smk',
        // 'pejabat_id',
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
    // public function pejabatSatuan()
    // {
    //     return $this->belongsTo(PejabatSatuan::class, 'pejabat_id');
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
