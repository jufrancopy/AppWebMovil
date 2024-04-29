<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Specialty;
use App\Models\Appointment;
use App\Models\CancelledAppointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        if ($role == 'admin') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->paginate(10);
            $historialAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->paginate(10);
        } elseif ($role == 'doctor') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('doctor_id', Auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('doctor_id', Auth()->id())
                ->paginate(10);
            $historialAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('doctor_id', Auth()->id())
                ->paginate(10);
        } elseif ($role == 'patient') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('patient_id', Auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('patient_id', Auth()->id())
                ->paginate(10);
            $historialAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('patient_id', Auth()->id())
                ->paginate(10);
        }

        return view('appointments.index', get_defined_vars());
    }
    public function show(Appointment $appointment)
    {
        $role = auth()->user()->role;

        return view('appointments.show', compact('appointment', 'role'));
    }
    public function create(ScheduleServiceInterface $scheduleService)
    {

        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if ($specialtyId) {
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else {
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if ($date && $doctorId) {
            $intervals = $scheduleService->getAvailableIntervals($date, $doctorId);
        } else {
            $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'doctors', 'intervals'));
    }

    public function store(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required'
        ];

        $messages = [
            'scheduled_time.required' => 'Por favor seleccione una hora válida para su cita'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request, $scheduleService) {
            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $scheduledTime = $request->input('scheduled_time');
            if ($date && $doctorId && $scheduledTime) {
                $start = new Carbon($scheduledTime);
            } else {
                return;
            }
            if (!$scheduleService->isAvailableInterval($date, $doctorId, $start)) {
                $validator->errors()
                    ->add('available_time', 'La hora seleccionada se encuentra reservada por otro paciente.');
            }
        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->only([
            'description',
            'specialty_id',
            'doctor_id',
            'scheduled_date',
            'scheduled_time',
            'type'
        ]);

        $data['patient_id'] = auth()->id();

        // Right time format
        // $carbonTime = Carbon::createFromFormat('g:i A', $data = ['scheduled_time']);
        // $data['scheduled_time'] = $carbonTime->format('H:i:s');

        Appointment::create($data);

        $notification = "La cita se ha registrado correctamente";

        return back()->with(compact('notification'));
    }

    public function showCancelForm(Appointment $appointment)
    {
        if ($appointment->status == 'Confirmada') {
            $role = auth()->user()->role;
            return view('appointments.cancel-appointments', get_defined_vars());
        }
        return redirect()->route('appointments.index');
    }
    public function postCancel(Appointment $appointment, Request $request)
    {
        if ($request->has('justification')) {
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->justification;
            $cancellation->cancelled_by_id =  auth()->id();

            $appointment->cancellation()->save($cancellation);
            $notification = 'La cita se ha cancelado correctamente';
        }


        $appointment->status  = 'Cancelada';
        $appointment->save();

        $notification = 'La cita se ha cancelado correctamente';

        return redirect(route('appointments.index'))->with(compact('notification'));
    }

    public function postConfirm(Appointment $appointment)
    {
        $appointment->status  = 'Confirmada';
        $appointment->save();

        $notification = 'La cita se ha confirmada correctamente';

        return redirect(route('appointments.index'))->with(compact('notification'));
    }
}
