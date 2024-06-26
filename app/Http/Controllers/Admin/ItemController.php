<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(10);
        
        $trashedItems = Item::onlyTrashed()->get();

        return view('admin.items.index', compact(['items', 'trashedItems']));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        // Reglas de validación
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'type' => 'required|in:supplies,medicines',
        ];

        // Mensajes de validación
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'in' => 'El campo :attribute debe ser uno de :values.',
        ];

        // Nombres de atributos personalizados
        $attributes = [
            'name' => 'Nombre',
            'description' => 'Descripción',
            'price' => 'Precio',
            'type' => 'Tipo',
        ];

        // Validar los datos recibidos en la solicitud
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear un nuevo item
        $item = Item::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'type' => $request->input('type'),
        ]);

        // Redireccionar con una notificación
        $notification = 'El item ha sido registrado correctamente';
        return redirect('items')->with(compact('notification'));
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'type' => 'required',
        ];

        $messages = [
            'required'          => 'El campo :attribute es requerido.',
            'required'          => 'El campo :attribute es requerido.',
            'required'          => 'El campo :attribute es requerido',
            'required'          => 'El campo :attribute es requerido',
        ];

        $attributes = [
            'name'              => 'Nombre',
            'description'       => 'Descripción',
            'price'             => 'Precio',
            'type'              => 'Tipo',
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

    public function confirmDelete(Item $item)
    {
        return view('admin.items.delete', compact('item'));
    }

    public function destroy(Request $request, Item $item)
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
        $item->delete_reason = $deleteReason;
        $item->save();

        // Eliminar el formulario
        $item->delete();

        return redirect('items')->with('notification', 'El Ítem ha sido eliminado correctamente');
    }

    public function showTrash()
    {
        $trashedItems = Item::onlyTrashed()->get();

        return view('items.trash', compact('trashedItems'));
    }

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();

        return redirect()->back()->with('notification', 'El ítem ha sido restaurado correctamente');
    }
}
