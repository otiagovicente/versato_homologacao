<!-- BEGIN PAGE HEADER-->

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{ url('/brands') }}">Brands</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{ url($url) }}">{{ $pageTitle }}</a>
                </li>
            </ul>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                    Actions <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                            <a href="{{ url('/brands') }}">Ver Todos</a>
                        </li>
                        <li>
                            <a href="{{ url('/brands/create') }}">Criar Marca </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER-->
<h3 class="page-title">
    Marcas <small>{{ $pageTitle }}</small>
</h3>