@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
        <div class="container">

            <h2 class="mb-4">📊 Reportes</h2>

            <!-- Tarjetas resumen -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">💰 Total Hoy</h5>
                                    <h3>${{ number_format($ventasDiarias->first()->total ?? 0, 0, ',', '.') }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                            <p class="card-text">Ventas del día</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">🧾 Tickets</h5>
                                    <h3>{{ $ventasDiarias->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-receipt fa-2x"></i>
                                </div>
                            </div>
                            <p class="card-text">Ventas registradas</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-info shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">👤 Nuevos clientes</h5>
                                    <h3>+3</h3> {{-- Podés cambiarlo por una variable real --}}
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-user-plus fa-2x"></i>
                                </div>
                            </div>
                            <p class="card-text">Esta semana</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-warning shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">⚠️ Stock bajo</h5>
                                    <h3>2</h3> {{-- Podés pasarlo desde el controlador --}}
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-box-open fa-2x"></i>
                                </div>
                            </div>
                            <p class="card-text">Productos a reponer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">📅 Ventas Diarias</div>
                        <div class="card-body">
                            <canvas id="chartDiarias" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">📈 Ventas Semanales</div>
                        <div class="card-body">
                            <canvas id="chartSemanales" height="100"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">🏆 Top Productos Más Vendidos</div>
                        <div class="card-body">
                            <canvas id="chartTopProductos" height="100"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">👥 Ventas por Cliente</div>
                        <div class="card-body">
                            <canvas id="chartClientes" height="100"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">💳 Ventas por Método de Pago</div>
                        <div class="card-body">
                            <canvas id="chartMetodosPago" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>




            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                //console.log('Script de gráficos cargado');
                //alert('JS cargado');
                const ctxDiarias = document.getElementById('chartDiarias').getContext('2d');
                const ctxSemanales = document.getElementById('chartSemanales').getContext('2d');

                const fechasDiarias = {!! json_encode($ventasDiarias->pluck('fecha')) !!};
                const totalesDiarias = {!! json_encode($ventasDiarias->pluck('total')) !!};

                const labelsSemanales = {!! json_encode(
        $ventasSemanales->map(fn($r) => "Sem {$r->semana} ({$r->desde} a {$r->hasta})")
    ) !!};
                const totalesSemanales = {!! json_encode($ventasSemanales->pluck('total')) !!};

                console.log('Ventas Diarias:', fechasDiarias, totalesDiarias);
                console.log('Ventas Semanales:', labelsSemanales, totalesSemanales);

                new Chart(ctxDiarias, {
                    type: 'bar',
                    data: {
                        labels: fechasDiarias,
                        datasets: [{
                            label: 'Ventas diarias ($)',
                            data: totalesDiarias,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                new Chart(ctxSemanales, {
                    type: 'bar',
                    data: {
                        labels: labelsSemanales,
                        datasets: [{
                            label: 'Ventas semanales ($)',
                            data: totalesSemanales,
                            backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                // Top Productos
                new Chart(document.getElementById('chartTopProductos'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($topProductos->pluck('nombre')) !!},
                        datasets: [{
                            label: 'Cantidad vendida',
                            data: {!! json_encode($topProductos->pluck('total_vendido')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.7)'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                // Ventas por Cliente
                new Chart(document.getElementById('chartClientes'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($ventasPorCliente->pluck('nombre')) !!},
                        datasets: [{
                            label: 'Total gastado ($)',
                            data: {!! json_encode($ventasPorCliente->pluck('total_gastado')) !!},
                            backgroundColor: 'rgba(153, 102, 255, 0.7)'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                // Ventas por método de pago
                new Chart(document.getElementById('chartMetodosPago'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($ventasPorMetodo->pluck('metodo_pago')) !!},
                        datasets: [{
                            label: 'Total vendido ($)',
                            data: {!! json_encode($ventasPorMetodo->pluck('total')) !!},
                            backgroundColor: [
                                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            </script>


@endsection