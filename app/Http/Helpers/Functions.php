<?php

if (!function_exists('getTypeInputs')) {
    function getTypeInputs()
    {
        return [
            'text' => 'Texto Corto',
            'textarea' => 'Texto Largo',
            'select' => 'Selector de Elementos',
            'checkbox' => 'Casilla de Verificación',
            'radio' => 'Botón de Radio',
        ];
    }
}
