<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormTemplate;
use Illuminate\Support\Facades\Validator;


class FormTemplateController extends Controller
{
    public function index()
    {
        $templates = FormTemplate::paginate(10);

        $trashedTemplates = FormTemplate::onlyTrashed()->paginate(10);

        return view('admin.forms.form-templates.index', compact(['templates', 'trashedTemplates']));
    }

    public function create()
    {
        return view('admin.forms.form-templates.create');
    }

    public function store(Request $request)
    {
        // Reglas de validación
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'with_odontogram' => 'required',
        ];

        // Mensajes de validación
        $messages = [
            'required' => 'El campo :attribute es requerido.',
        ];

        // Nombres de atributos personalizados
        $attributes = [
            'name' => 'Nombre',
            'description' => 'Descripción',
            'with_odontogram' => 'Indique si el Formulario Requiere ODontograma'
        ];

        // Validar los datos recibidos en la solicitud
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear un nuevo item
        $item = FormTemplate::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'with_odontogram' => $request->has('with_odontogram') ? true : false,
        ]);

        // Redireccionar con una notificación
        $notification = 'La plantilla ha sido registrada correctamente';
        return redirect('form-templates')->with(compact('notification'));
    }

    public function edit(FormTemplate $formTemplate)
    {
        return view('admin.forms.form-templates.edit', compact('formTemplate'));
    }

    public function update(Request $request, FormTemplate $item)
    {
        $rules = [
            'name' => 'required'
        ];

        $messages = [
            'required'          => 'El campo :attribute es requerido.'
        ];

        $attributes = [
            'name'              => 'Nombre'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar los datos del estudio médico
        $item->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'type' => $request->input('type'),
        ]);

        // Redireccionar con una notificación
        $notification = 'La información del Ítem se ha actualizado correctamente';
        return redirect('items')->with(compact('notification'));
    }

    public function confirmDelete(FormTemplate $formTemplate)
    {
        return view('admin.forms.form-templates.delete', compact('formTemplate'));
    }

    public function destroy(Request $request, FormTemplate $formTemplate)
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
        $formTemplate->delete_reason = $deleteReason;
        $formTemplate->save();

        // Eliminar el formulario
        $formTemplate->delete();

        return redirect('form-templates')->with('notification', 'El Formulario ha sido eliminado correctamente');
    }

    public function showTrash()
    {
        $trashedItems = FormTemplate::onlyTrashed()->get();

        return view('items.trash', compact('trashedItems'));
    }

    public function restore($id)
    {
        $item = FormTemplate::onlyTrashed()->findOrFail($id);
        $item->restore();

        return redirect()->back()->with('notification', 'El ítem ha sido restaurado correctamente');
    }
}
