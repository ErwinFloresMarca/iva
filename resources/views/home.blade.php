@extends('layouts.app')
<?php
        use App\Gestion;
        use App\Mes;
        use App\Cliente;
        use App\Proveedor;
        $mes = Mes::all()->last();
        $LabelMeses= [];        
        $ventasPorMes = [];
        $comprasPorMes = [];
        foreach($mes->gestion->meses as $m){
            $LabelMeses[]=$m->mes;
            $ventasPorMes[]=count($m->ventas);
            $comprasPorMes[]=count($m->compras);
        }
    ?>

@section('scripts')
<script>
    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesChartData = {
    labels  : {!!json_encode($LabelMeses)!!},
    datasets: [
      {
        label               : 'Compras',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : true,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : {!!json_encode($comprasPorMes)!!}
      },
      {
        label               : 'Ventas',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : true,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : {!!json_encode($ventasPorMes)!!}
      },
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }],
      yAxes: [{
        gridLines : {
          display : false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if($mes)
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{count($mes->compras)}}</h3>
                            <p>COMPRAS<br>{{$mes->mes}} - {{$mes->gestion->gestion}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('compra.mes',$mes->id)}}" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{count($mes->ventas)}}</h3>
                            <p>VENTAS<br>{{$mes->mes}} - {{$mes->gestion->gestion}}</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('venta.mes',$mes->id)}}" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6" >
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner" style="color: white;">
                            <h3>{{Cliente::count()}}</h3>

                            <p>Clientes<br>Registrados</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('cliente.index')}}" class="small-box-footer"> <div style="color: white;">Mas informacion <i class="fas fa-arrow-circle-right"></i></div></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{Proveedor::count()}}</h3>

                        <p>Proveedores<br>Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('proveedor.index')}}" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
            <section class="col-lg-12 connectedSortable ui-sortable">
                <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Estadisticas de la ultima Gestion
                    </h3>
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Lista</a>
                        </li>
                    </ul>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="revenue-chart-canvas" height="300" style="height: 300px; display: block; width: 527px;" width="527" class="chartjs-render-monitor"></canvas>                         
                    </div>
                     
                    </div>
                </div><!-- /.card-body -->
                </div>
            </section>
            </div>
          @else
            <h3>NO TIENE NINGUNA INFORMACION</h3>
            <a href="{{route('mes.gestion',Gestion::ultimaGestion())}}">registre un mes</a>
          @endif
        </div>
    </div>
</div>
@endsection
