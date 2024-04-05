<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
	use HasFactory;

	protected $fillable = [
		'description',
		'specialty_id',
		'doctor_id',
		'patient_id',
		'scheduled_date',
		'scheduled_time',
		'type'
	];

	public function specialty()
	{
		return $this->belongsTo(Specialty::class);
	}

	public function doctor()
	{
		return $this->belongsTo(User::class);
	}

	public function patient()
	{
		return $this->belongsTo(User::class);
	}

	public function cancellation()
	{
		return $this->hasOne(CancelledAppointment::class);
	}

	// Accesor
	public function getScheduledTime12Attribute()
	{
		return (new Carbon($this->scheduled_time))
			->format('g:i A');
	}
}
