<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;

use App\Http\Controllers\Controller;
use App\Specialty;
use App\WorkDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    private $days = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo'
    ];

    public function index()
    {
        $doctors = User::doctors()->paginate(10);

        return view('doctors.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name'      => 'required|min:3',
            'email'     => 'required|email|unique:users',
            'ci'        => 'required|unique:users,ci',
            'address'   => 'nullable|min:5',
            'phone'     => 'nullable|min:6'
        ];

        $messages = [
            'required'  => 'El campo :attribute es requerido.',
            'unique'    => 'Ya existe el :attribute en nuestra base de datos.',
            'email'     => 'El :attribute debe ser una dirección de correo electrónico válida.',
            'min'       => 'El campo :attribute debe tener al menos :min caracteres.'
        ];

        $attributes = [
            'name'      => 'Nombre',
            'email'     => 'Correo electrónico',
            'address'   => 'Dirección',
            'phone'     => 'Teléfono',
            'ci'        => 'Cédula de Identidad'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create(
            $request->only('name', 'email', 'ci', 'address', 'phone')
                + [
                    'role'      =>  'doctor',
                    'password'  =>  bcrypt($request->input('password')),
                ]
        );

        $user->specialties()->attach($request->input('specialties'));
        $notification = 'El médico ha sido registrado correctamente';


        return redirect('doctors')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showHours(Request $request, $id) {
        $workDays = WorkDay::where('user_id', $id)->get();
        if(count($workDays) > 0) {
            $workDays->map(function ($workDay) {
                $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
                $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
                $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
                $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');
                return $workDay;
            });

        }else{
            $workDays = collect();
            for ($i = 0; $i<7; ++$i)
            $workDays->push(new WorkDay());
        }
        
        $days = $this->days;

         
        return view('schedule', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);
        $specialties = Specialty::all();

        $specialty_ids = $doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name'      => 'required|min:3',
            'email'     => 'required|email',
            'ci'        => 'nullable|digits:7|unique:users,ci,' . $id,
            'address'   => 'nullable|min:5',
            'phone'     => 'nullable|min:6'
        ];

        // Validar los datos recibidos del formulario
        $this->validate($request, $rules);

        // Buscar al médico por su ID
        $user = User::doctors()->findOrFail($id);

        // Obtener los datos del formulario
        $data = $request->only('name', 'email', 'ci', 'address', 'phone');

        // Verificar si se proporcionó una nueva contraseña
        $password = $request->input('password');
        if ($password) {
            $data['password'] = bcrypt($password);
        }

        // Actualizar los datos del médico
        $user->fill($data);
        $user->save();

        // Sincronizar las especialidades del médico
        $user->specialties()->sync($request->input('specialties'));

        // Redireccionar con una notificación
        $notification = 'La información del médico se ha actualizado correctamente';
        return redirect('doctors')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        $doctorName = $doctor->name;

        // Verificar si el doctor tiene días agendados
        if ($doctor->workDays()->exists()) {
            $notification = "No se puede eliminar al Doctor $doctorName porque tiene días agendados previamente.";

            return redirect(route('doctors.index'))->with('danger', compact('notification'));
        }

        // Si no tiene días agendados, proceder con la eliminación
        $doctor->delete();

        $notification = "Doctor $doctorName eliminado de la BD correctamente";
        return redirect(route('doctors.index'))->with(compact('notification'));
    }
}
