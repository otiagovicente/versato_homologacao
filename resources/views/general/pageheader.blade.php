<div class="x_title">
    <h2>{{$section}}
         <small>{{$pageTitle}} </small></h2>
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Acciones
            </a>
            <ul class="dropdown-menu" role="menu">

                @if($actions != null)
                    @foreach($actions as $action => $url)
                        <li>
                            <a href="{{ url($url) }}">{{ $action }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
    </ul>
    <div class="clearfix"></div>
</div>