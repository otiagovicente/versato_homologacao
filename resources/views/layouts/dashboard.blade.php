<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->

	@include('dashboard.head')
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-sidebar-opened">

        <div id="app-vue">
            @include('dashboard.header')
            @include('dashboard.sidebar')
            @include('dashboard.quicksidebar')
            @include('dashboard.content')
            @include('dashboard.footer')
            @include('dashboard.javascripts')
        </div>
    </body>

</html>