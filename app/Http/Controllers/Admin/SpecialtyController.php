<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Specialty;

use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $specialties = Specialty::all();

        return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }

    private function performValidation(Request $request)
    {
        $rules = [
            'name' => 'required | min:3',
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar un nombre',
            'name.min' => 'El nombre debe contener al menos 3 caracteres.'
        ];
        $this->validate($request,$rules,$messages);
    }

    public function store(Request $request)
    {
        
        $this->performValidation($request);
        $specialty = Specialty::create($request->all());
        $notification = 'Especialidad agregada correctamente!';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, $id)
    {
        $this->performValidation($request);
        $specialty = Specialty::find($id);
        $specialty->fill($request->all());
        $specialty->save();
        $notification = 'Especialidad editada correctamente!';
        
        return redirect('/specialties')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty){
        $deletedName = $specialty->name;
        $specialty->delete();
        $notification = 'Especialidad '.$deletedName.' eliminada correctamente!';
        
        return redirect('/specialties')->with(compact('notification'));
    }
}
