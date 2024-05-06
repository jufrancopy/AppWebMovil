<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_templates';

    protected $fillable = ['name', 'description', 'with_odontogram'];

    public function fields()
    {
        return $this->hasMany(FormField::class, 'form_template_id');
    }

    public static function getForms()
    {
        return static::pluck('name', 'id');
    }
}
