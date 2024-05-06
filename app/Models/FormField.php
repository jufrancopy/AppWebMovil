<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'type'];

    public function template()
    {
        return $this->belongsTo(FormTemplate::class, 'form_template_id');
    }
}
