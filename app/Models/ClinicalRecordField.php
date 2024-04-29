<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalRecordField extends Model
{
    use HasFactory;

    protected $fillable = ['clinical_record_id', 'type'];

    public function template()
    {
        return $this->belongsTo(ClinicalRecordTemplate::class, 'clinical_record_id');
    }
}
