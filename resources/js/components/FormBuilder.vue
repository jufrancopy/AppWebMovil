<template>
    <div id="form-builder">
        <div class="field-list">
            <div
                v-for="field in fields"
                :key="field.id"
                class="field-item"
                draggable
                @dragstart="startDrag($event, field)"
            >
                {{ field.label }}
            </div>
        </div>

        <div class="drop-area" @drop="onDrop($event)" @dragover.prevent @dragenter.prevent>
            <p v-if="!formFields.length">Arrastra aquí los campos para construir tu formulario</p>
            <div v-for="formField in formFields" :key="formField.id" class="form-field">
                <span>{{ formField.label }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FormBuilder', // Agrega un nombre al componente
    data() {
        return {
            fields: [
                { id: 1, label: 'Nombre' },
                { id: 2, label: 'Correo electrónico' },
                { id: 3, label: 'Mensaje' },
            ],
            formFields: [],
            draggedField: null,
        };
    },
    methods: {
        startDrag(event, field) {
            event.dataTransfer.dropEffect = 'move';
            event.dataTransfer.effectAllowed = 'move';
            this.draggedField = field;
        },
        onDrop(event) {
            console.log('Drop event occurred!');
            if (this.draggedField) {
                this.formFields.push(this.draggedField);
                this.draggedField = null;
            }
            console.log('Form fields:', this.formFields);
        },
    },
};
</script>
