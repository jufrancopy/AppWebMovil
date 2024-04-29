<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $patients = User::patients()->paginate(10);

        return view('patients.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
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
            'name'      =>  'required | min:3',
            'email'     =>  'required | email',
            'ci'        =>  'nullable | digits:7',
            'address'   =>  'nullable | min:5',
            'phone'     =>  'nullable | min:6'
        ];
        $this->validate($request, $rules);
        User::create(
            $request->only('name', 'email', 'ci', 'address', 'phone')
                + [
                    'role'      =>  'patient',
                    'password'  =>  bcrypt($request->input('password')),
                ]
        );
        $notification = 'El paciente ha sido registrado correctamente';


        return redirect('/patients')->with(compact('notification'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = User::patients()->findOrFail($id);


        return view('patients.edit', get_defined_vars());
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
            'name'      =>  'required | min:3',
            'email'     =>  'required | email',
            'ci'        =>  'nullable | digits:7',
            'address'   =>  'nullable | min:5',
            'phone'     =>  'nullable | min:6'
        ];
        $this->validate($request, $rules);
        $user = User::patients()->findOrFail($id);
        $data = $request->only('name', 'email', 'ci', 'address', 'phone');
        $password = $request->input('password');

        if ($password)
            $data['password'] = bcrypt($password);
        $user->fill($data);
        $user->save();

        $notification = 'La información del paciente se ha actualizado correctamente';

        return redirect('/patients')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patient)
    {
        $patientName = $patient->name;
        $patient->delete();

        $notification = "El paciente $patientName ha sido eliminado del sistema";

        return redirect('/patients')->with(compact('notification'));
    }
}
