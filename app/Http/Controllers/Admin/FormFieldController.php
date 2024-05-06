<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\FormTemplate;
use App\Models\FormField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormFieldController extends Controller
{
    public function index()
    {
        $fields = FormField::paginate(10);
        $trashedFields = FormField::onlyTrashed()->paginate(10);

        return view('admin.forms.form-fields.index', compact(['fields', 'trashedFields']));
    }

    public function create()
    {
        $formFields = FormField::getForms();

        return view('admin.forms.form-fields.create', compact('formFields'));
    }

    public function store(Request $request)
    {
        // Reglas de validación
        $rules = [
            'form_template_id' => 'required|exists:form_templates,id',
            'name' => 'required',
            'type' => 'required|in:text,textarea,checkbox,select,radio',
        ];

        // Mensajes de validación
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'in' => 'El campo :attribute debe ser uno de :values.',
            'exists' => 'El :attribute seleccionado no existe.',
        ];

        // Nombres de atributos personalizados
        $attributes = [
            'form_template_id' => 'Plantilla de formulario',
            'name' => 'Nombre',
            'type' => 'Tipo',
        ];

        // Validar los datos recibidos en la solicitud
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear un nuevo campo
        $field = FormField::create([
            'form_template_id' => $request->input('form_template_id'),
            'name' => $request->input('name'),
            'type' => $request->input('type'),
        ]);

        // Redireccionar con una notificación
        $notification = 'El campo ha sido registrado correctamente';
        return redirect()->route('form-fields.index')->with(compact('notification'));
    }

    public function edit(FormField $formField)
    {
        $formTemplates = FormTemplate::getForms();

        return view('admin.forms.form-fields.edit', compact(['formField', 'formTemplates']));
    }

    public function update(Request $request, FormField $formField)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formField->update([
            'name' => $request->input('name'),
        ]);

        $notification = 'La información del campo se ha actualizado correctamente';
        return redirect()->route('form-fields.index')->with(compact('notification'));
    }

    public function confirmDelete(FormField $formField)
    {
        return view('admin.forms.form-fields.delete', compact('formField'));
    }

    public function destroy(Request $request, FormField $formField)
    {
        $validator = Validator::make($request->all(), [
            'delete_reason' => $request->delete_reason === 'other' ? 'required' : 'required_without:delete_reason_other',
            'delete_reason_other' => $request->delete_reason === 'other' ? 'required' : '',
        ], [
            'required' => 'El campo :attribute es requerido.',
            'required_without' => 'El campo :attribute es requerido cuando :values no está presente.',
        ], [
            'delete_reason' => 'Motivo de Eliminación',
            'delete_reason_other' => 'Otro Motivo de Eliminación',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $deleteReason = $request->delete_reason === 'other' ? "Otro: " . $request->delete_reason_other : $request->delete_reason;

        $formField->delete_reason = $deleteReason;
        $formField->save();

        $formField->delete();

        return redirect()->route('form-fields.index')->with('notification', 'El campo ha sido eliminado correctamente');
    }

    public function showTrash()
    {
        $trashedFields = FormField::onlyTrashed()->get();
        return view('admin.forms.form-fields.trash', compact('trashedFields'));
    }

    public function restore($id)
    {
        $field = FormField::onlyTrashed()->findOrFail($id);
        $field->restore();

        return redirect()->route('form-fields.index')->with('notification', 'El campo ha sido restaurado correctamente');
    }
}
