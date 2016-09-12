@extends('layouts.dashboard')
@section('styles')
    <link href="/dashboard/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')

    <script src="/dashboard/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/horizontal-timeline/horozontal-timeline.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
    <script src="/dashboard/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

    <script src="/dashboard/pages/scripts/dashboard.min.js" type="text/javascript"></script>

@endsection



@section('content')

    @include('pages.partials.header')
    <h1 class="page-title"> Productos
        <small>Estatisticas & Datos</small>
    </h1>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="/lines">
                <div class="visual">
                    <i class="fa fa-sitemap"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$linesCount}}">0</span>
                    </div>
                    <div class="desc"> Lineas </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue-steel" href="/references">
                <div class="visual">
                    <i class="fa fa-barcode"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$referencesCount}}">0</span>
                    </div>
                    <div class="desc"> Referencias </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green-steel" href="/materials">
                <div class="visual">
                    <i class="fa fa-diamond"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$materialsCount}}">0</span>
                    </div>
                    <div class="desc"> Materiales </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow-lemon" href="/colors">
                <div class="visual">
                    <i class="fa fa-eyedropper"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$colorsCount}}">0</span>
                    </div>
                    <div class="desc"> Colores </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="/products">
                <div class="visual">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{$productsCount}}">0</span>
                    </div>
                    <div class="desc"> Productos </div>
                </div>
            </a>
        </div>



    </div>

@endsection