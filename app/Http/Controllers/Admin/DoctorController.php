<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;

use App\Http\Controllers\Controller;
use App\Specialty;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
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
            'name'      =>  'required | min:3',
            'email'     =>  'required | email',
            'ci'        =>  'nullable | digits:6',
            'address'   =>  'nullable | min:5',
            'phone'     =>  'nullable | min:6'
        ];
        $this->validate($request, $rules);

        $user = User::create(
            $request->only('name', 'email', 'ci', 'address', 'phone')
        + [
            'role'      =>  'doctor',
            'password'  =>  bcrypt($request->input('password')),
        ]);

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
        return view ('doctors.edit', get_defined_vars());
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
        $user = User::doctors()->findOrFail($id);
        $data = $request->only('name', 'email', 'ci', 'address', 'phone');
        $password = $request->input('password');
        
        if ($password)
            $data['password'] = bcrypt($password);
        $user->fill($data);
        $user->save();

        $user->specialties()->sync($request->input('specialties'));

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
        $doctor->delete();
        $notification = "Doctor $doctorName eliminado de la BD correctamente";

        return redirect(route('doctors.index'))->with(compact('notification'));
    }
}
