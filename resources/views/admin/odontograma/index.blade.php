@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Odontograma</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <svg viewBox="0 0 1000 500" xmlns="http://www.w3.org/2000/svg">
                @for ($i = 1; $i <= 32; $i++)
                    @php
                        // Calcular la posición del diente en la cuadrícula
                        $x = ($i - 1) % 8 * 120 + 40;
                        $y = floor(($i - 1) / 8) * 100 + 40;
                    @endphp
                    <!-- Círculo exterior -->
                    <circle cx="{{ $x + 40 }}" cy="{{ $y + 50 }}" r="30" fill="none" stroke="#000000" stroke-width="2" />
                    <!-- Cuadrantes -->
                    @for ($j = 0; $j < 4; $j++)
                        @php
                            $startX = $x + 40 + 30 * cos(deg2rad($j * 90));
                            $startY = $y + 50 + 30 * sin(deg2rad($j * 90));
                            $endX = $x + 40 + 15 * cos(deg2rad(($j + 1) * 90));
                            $endY = $y + 50 + 15 * sin(deg2rad(($j + 1) * 90));
                        @endphp
                        <line x1="{{ $startX }}" y1="{{ $startY }}" x2="{{ $endX }}" y2="{{ $endY }}" stroke="#000000" stroke-width="2" />
                    @endfor
                    <!-- Círculo interior -->
                    <circle cx="{{ $x + 40 }}" cy="{{ $y + 50 }}" r="15" fill="none" stroke="#000000" stroke-width="2" />
                    <!-- Número -->
                    <text x="{{ $x + 40 }}" y="{{ $y + 55 }}" font-size="12" text-anchor="middle" fill="#000000">{{ $i }}</text>
                @endfor
            </svg>
            
        </div>
    </div>
@endsection

@section('styles')
    <style>
        svg {
            width: 100%;
            height: auto;
            max-width: 800px; /* Limita el ancho máximo para que no sea demasiado grande */
        }
    </style>
@endsection

