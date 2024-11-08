<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $users }}</h3>
                        <p>Usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="{{ route('admin.usuario.index') }}" class="small-box-footer">Más información<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $estudiantes }}</h3>
                        <p>ESTUDIANTES</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-users fa-lg"></i>
                    </div>
                    <a href="{{ route('admin.estudiante.index') }}" class="small-box-footer">Más información<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $programas }}</h3>
                        <p>PROGRAMAS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-clipboard fa-lg"></i>
                    </div>
                    <a href="{{ route('admin.programa.index') }}" class="small-box-footer">Más información<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $rubros }}</h3>
                        <p>RUBROS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-book-medical fa-lg"></i>
                    </div>
                    <a href="{{ route('admin.rubro.index') }}" class="small-box-footer">Más información<i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Graficos
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Barras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sales-chart" data-toggle="tab">Dona</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                        <canvas id="revenue-chart-canvas" height="w-full" style="height: 300px;"></canvas>
                    </div>
                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                        <canvas id="sales-chart-canvas" height="w-full" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var rubroData = @json($rubroData);
            var boletasData = @json($boletasData);

            // Gráfico de área (pedidos por mes) 
            var ctxRevenue = document.getElementById('revenue-chart-canvas').getContext('2d');
            var revenueChart = new Chart(ctxRevenue, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    datasets: [{
                        label: 'Boletas Emitidas por Mes',
                        data: Array(12).fill(0).map((_, i) => boletasData[i + 1] || 0),
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }
            });

            // Gráfico de dona (productos por categoría) 
            var ctxSales = document.getElementById('sales-chart-canvas').getContext('2d');
            var salesChart = new Chart(ctxSales, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(rubroData),
                    datasets: [{
                        data: Object.values(rubroData),
                        backgroundColor: [
                            '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                            '#605ca8', '#ff851b', '#39cccc', '#01ff70', '#3d9970', '#ff4136'
                        ],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'right',
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var currentValue = dataset.data[tooltipItem.index];
                                return data.labels[tooltipItem.index] + ': ' + currentValue + '%';
                            }
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            formatter: function(value, context) {
                                return context.chart.data.labels[context.dataIndex] + '\n' + value +
                                    '%';
                            }
                        }
                    }
                }
            });
        });
    </script>
