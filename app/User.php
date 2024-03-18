<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ci', 'address', 'phone', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    public function specialties(){
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopePatients($query){
        return $query->where('role', 'patient');
    }

    public function scopeDoctors($query){
        return $query->where('role', 'doctor');
    }
}
