<head>
    <meta charset="utf-8" />
    <title>Versato - Vendas e Relacionamento em calçados</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <meta content="Versato App" name="description" />
    <meta content="Magna Estrategia" name="author" />
    <meta id="_token" value="{{ csrf_token() }}"> 
@yield('metatags')

<!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/app.css" type="text/css"/>

    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    {{--<link href="/dashboard/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />--}}
    {{--<link href="/dashboard/global/css/plugins.min.css" rel="stylesheet" type="text/css" />--}}
    {{--<!-- END THEME GLOBAL STYLES -->--}}
    {{--<!-- BEGIN THEME LAYOUT STYLES -->--}}
    {{--<link href="/dashboard/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />--}}
    {{--<link href="/dashboard/layouts/layout/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />--}}
    {{--<link href="/dashboard/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />--}}
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIN PAGE STYLES -->
@yield('styles')
<!-- END PAGE STYLES -->
    <link rel="shortcut icon" href="/images/favicon.png" />

    @yield('scripts.header')
</head>
