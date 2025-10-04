@extends('layouts.app')

@section('content')
<div class="container ">
    <x-header-bar 
        title="Historial de Cierres de Caja"
        :buttons="[
            ['text' => '+ Nuevo Cierre', 'route' => route('cierres.create'), 'class' => 'btn-dark btn-sm']
        ]"
    />

    @if(session('success'))
        <div class="alert alert-success small">
            {{ session('success') }}
        </div>
    @endif

   


<div class="container">
    <h1>Cierres de Caja - {{ $mes }}/{{ $anio }}</h1>

    <form method="GET" class="mb-3 d-flex gap-2">
        <select name="mes" class="form-select">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $mes == $i ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
        <input type="number" name="anio" value="{{ $anio }}" class="form-control" style="width:120px;">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Efectivo</th>
                <th>Tarjeta</th>
                <th>Cuotas</th>
                <th>Otros</th>
                <th>Egresos</th>
                <th>Saldo Día</th>
                <th>Obs.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cierres as $cierre)
                <tr>
                    <td>{{ $cierre->fecha }}</td>
                    <td>${{ number_format($cierre->ingreso_efectivo,2) }}</td>
                    <td>${{ number_format($cierre->ingreso_tarjeta,2) }}</td>
                    <td>${{ number_format($cierre->ingreso_cuotas,2) }}</td>
                    <td>${{ number_format($cierre->otros_ingresos,2) }}</td>
                    <td class="text-danger">-${{ number_format($cierre->egresos,2) }}</td>
                    <td class="fw-bold {{ $cierre->saldo_dia >= 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($cierre->saldo_dia,2) }}
                    </td>
                    <td>{{ $cierre->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-secondary">
                <td colspan="6" class="text-end"><strong>Total del Mes</strong></td>
                <td colspan="2" class="fw-bold">${{ number_format($totalMes,2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>


@endsection
