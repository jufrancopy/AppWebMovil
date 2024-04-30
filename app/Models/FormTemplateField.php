<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormTemplateField extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'form_template_id', 'type'];

    public function template()
    {
        return $this->belongsTo(FormTemplate::class, 'form_template_id');
    }
}
