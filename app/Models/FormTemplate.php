<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormTemplate extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'form_templates';

    protected $fillable = ['name'];
}
