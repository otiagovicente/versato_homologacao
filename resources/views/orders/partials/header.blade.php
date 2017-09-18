<!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{ url('/order') }}">Materiais</a>
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
                            <a href="{{ url('/orders') }}">Ver Todos</a>
                        </li>
                        @if($exportToExcel != null)
                              {{ csrf_field() }}
                            <export-data></export-data>
                        @endif
                        <li>
                            <a href="{{ url('/orders/create') }}">Criar Pedido</a>
                        </li>
                        @if($actions != null)
                            @foreach($actions as $action => $url)
                                <li>
                                    <a href="{{ url($url) }}">{{ $action }}</a>
                                </li>
                            @endforeach
                        @endif
                        <li class="divider">
                        </li>
                        <li>
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <h3 class="page-title">
            Pedidos <small>{{ $pageTitle }}</small>
        </h3>
        <!-- END PAGE HEADER-->