@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Confirmar Eliminación</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p>
                ¿Estás seguro de que deseas eliminar el item <strong>{{ $study->name }}</strong>?
            </p>
            <form action="{{ route('studies.destroy', $study->id) }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="form-group">
                    <label for="delete_reason">Motivo de la eliminación (opcional):</label>
                    <select class="form-control" id="delete_reason_select" name="delete_reason">
                        <option value="expired">Vencido</option>
                        <option value="sin_uso">Sin uso</option>
                        <option value="other">Otro</option>
                        <option value="default" selected>Seleccionar...</option>
                    </select>
                </div>

                <div class="form-group" id="delete_reason_other_group" style="display: none;">
                    <label for="delete_reason_other">Especificar otro motivo:</label>
                    <textarea name="delete_reason_other" id="delete_reason_other" rows="3" class="form-control"></textarea>
                </div>

                <button class="btn btn-danger" type="submit">Eliminar Estudio</button>
                <a href="{{ url('/studies') }}" class="btn btn-default">Cancelar</a>

            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var deleteReasonSelect = document.getElementById("delete_reason_select");
        var deleteReasonOtherGroup = document.getElementById("delete_reason_other_group");
        var deleteReasonOtherInput = document.getElementById("delete_reason_other");

        deleteReasonSelect.addEventListener("change", function() {
            var selectedOption = deleteReasonSelect.value;
            if (selectedOption === "other") {
                deleteReasonOtherGroup.style.display = "block";
            } else {
                deleteReasonOtherGroup.style.display = "none";
                
                deleteReasonOtherInput.value = "";
            }   
        });
    });
</script>
@stop
