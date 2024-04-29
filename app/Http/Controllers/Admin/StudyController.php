<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudyController extends Controller
{
    public function index()
    {
        $studies = Study::paginate(10);

        return view('admin.studies.index', compact('studies'));
    }

    public function create()
    {
        return view('admin.studies.create');
    }

    public function store(Request $request)
    {

        $rules = [
            'name'              => 'required',
            'description'        => 'required',
            'price'             => 'required',
        ];

        $messages = [
            'required'          => 'El campo :attribute es requerido.',
            'required'    => 'El campo :attribute es requerido.',
            'required'         => 'El campo :attribute es requerido',
        ];

        $attributes = [
            'name'          => 'Nombre',
            'description'    => 'Descripción',
            'price'         => 'Precio'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $study = Study::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        $notification = 'El Estudio ha sido registrado correctamente';


        return redirect('studies')->with(compact('notification'));
    }

    public function edit(Study $study)
    {
        return view('admin.studies.edit', compact('study'));
    }

    public function update(Request $request, Study $study)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ];

        $messages = [
            'required'          => 'El campo :attribute es requerido.',
            'required'    => 'El campo :attribute es requerido.',
            'required'         => 'El campo :attribute es requerido',
        ];

        $attributes = [
            'name'          => 'Nombre',
            'description'    => 'Descripción',
            'price'         => 'Precio'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar los datos del estudio médico
        $study->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        // Redireccionar con una notificación
        $notification = 'La información del estudio médico se ha actualizado correctamente';
        return redirect('studies')->with(compact('notification'));
    }

    public function destroy(Study $study)
    {
        $study->delete();
        return redirect('studies')->with('notification', 'El estudio ha sido eliminado correctamente');
    }
}
