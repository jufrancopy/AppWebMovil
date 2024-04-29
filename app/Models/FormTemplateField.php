<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormTemplateField extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['clinical_record_id', 'type'];

    public function template()
    {
        return $this->belongsTo(FormTemplate::class, 'clinical_record_id');
    }
}
