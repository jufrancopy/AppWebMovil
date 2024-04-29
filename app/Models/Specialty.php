<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {

        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
