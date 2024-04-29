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

        $trashedStudies  = Study::onlyTrashed()->get();

        return view('admin.studies.index', compact(['studies', 'trashedStudies']));
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

    public function confirmDelete(Study $study)
    {
        return view('admin.studies.delete', compact('study'));
    }

    public function destroy(Request $request, Study $study)
    {

        // Definir reglas de validación
        $rules = [
            'delete_reason' => $request->delete_reason === 'other' ? 'required' : 'required_without:delete_reason_other',
            'delete_reason_other' => $request->delete_reason === 'other' ? 'required' : '',
        ];

        // Definir mensajes de validación
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'required_without' => 'El campo :attribute es requerido cuando :values no está presente.',
        ];

        // Definir atributos personalizados para mensajes de error
        $attributes = [
            'delete_reason' => 'Motivo de Eliminación',
            'delete_reason_other' => 'Otro Motivo de Eliminación',
        ];

        // Validar los datos recibidos del formulario
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Establecer el motivo de eliminación según la selección del usuario
        $deleteReason = $request->delete_reason === 'other' ? "Otro: " . $request->delete_reason_other : $request->delete_reason;

        // Guardar el motivo de eliminación en el modelo
        $study->delete_reason = $deleteReason;
        $study->save();

        // Eliminar el formulario
        $study->delete();

        return redirect('studies')->with('notification', 'El estudio ha sido eliminado correctamente');
    }

    public function showTrash()
    {
        $trashedStudies = Study::onlyTrashed()->get();

        return view('studies.trash', compact('trashedStudies'));
    }

    public function restore($id)
    {
        $study = Study::onlyTrashed()->findOrFail($id);
        $study->restore();

        return redirect()->back()->with('notification', 'El Estudio ha sido restaurado correctamente');
    }
}
