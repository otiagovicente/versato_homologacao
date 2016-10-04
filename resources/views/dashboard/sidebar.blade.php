<!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu page-sidebar-menu-light page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 0px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <li class="heading">
                                <h3 class="uppercase">Marca Selecionada</h3>
                            </li>
                            <li class="nav-item start">
                                <a href="/brands/select">
                                    <i class="icon-tag"></i>
                                    <span class="title">{{Session::get('brand')->name}}</span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase">Relatórios</h3>
                            </li>
                            <li class="nav-item start ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item start ">
                                        <a href="/productsdashboard" class="nav-link nav-toggle">
                                            <i class="icon-bar-chart"></i>
                                            <span class="title">Dashboard de Productos</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                             <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-trademark"></i>
                                    <span class="title">Marcas</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="{{ url('/brands') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Visualizar Marcas</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/brands/create') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Criar Marca</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase">Productos</h3>
                            </li>
                          
                           <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-sitemap"></i>
                                    <span class="title">Líneas</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="{{ url('/lines') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Mostrar Todas</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/lines/create') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Crear Línea</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>



                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-barcode"></i>
                                    <span class="title">Referencias</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/references" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Ver Todas</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/references/create" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Criar Referencia</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>

                                </ul>
                            </li>



                           <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-diamond"></i>
                                    <span class="title">Materiales</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/materials" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Ver Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/materials/create" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Crear Material</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                     
                                </ul>
                            </li>





                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-eyedropper"></i>
                                    <span class="title">Colores</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">

                                    <li class="nav-item">
                                        <a href="{{ url('/colors') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Ver todas</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/colors/create') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Crear Cor</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>


                                </ul>
                            </li>









                           <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-tags"></i>
                                    <span class="title">Productos</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/products" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Ver Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/products/create" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Crear Producto</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                     
                                </ul>
                            </li>


                            <li class="heading">
                                <h3 class="uppercase">Clientes</h3>
                            </li>

                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-black-tie"></i>
                                    <span class="title">Clientes</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="{{ url('/customers') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span class="title">Mostrar Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/customers/create') }}" class="nav-link nav-toggle">
                                            <i class="fa fa-plus"></i>
                                            <span class="title">Crear Cliente</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>




                                </ul>
                            </li>


                            <li class="heading">
                                <h3 class="uppercase">Representantes</h3>
                            </li>

                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-users"></i>
                                    <span class="title">Representantes</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/representatives" class="nav-link nav-toggle">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Ver Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/representatives/create" class="nav-link nav-toggle">
                                            <i class="icon-user-follow"></i>
                                            <span class="title">Crear</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>



                            <li class="heading">
                                <h3 class="uppercase">Regiones</h3>
                            </li>

                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-map"></i>
                                    <span class="title">Macro Regiones</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/macroregions" class="nav-link nav-toggle">
                                            <i class="fa fa-map"></i>
                                            <span class="title">Ver Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/macroregions/create" class="nav-link nav-toggle">
                                            <i class="fa fa-map"></i>
                                            <span class="title">Crear</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="title">Regiones</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/regions" class="nav-link nav-toggle">
                                            <i class="fa fa-map-marker"></i>
                                            <span class="title">Ver Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/regions/create" class="nav-link nav-toggle">
                                            <i class="fa fa-map-marker"></i>
                                            <span class="title">Crear</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>




                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="title">Tiendas</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/shops" class="nav-link nav-toggle">
                                            <i class="fa fa-map-marker"></i>
                                            <span class="title">Ver Todos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/shops/create" class="nav-link nav-toggle">
                                            <i class="fa fa-map-marker"></i>
                                            <span class="title">Crear</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>










                            <li class="heading">
                                <h3 class="uppercase">Sistema</h3>
                            </li>

                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Usu&aacute;rios</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/profile" class="nav-link nav-toggle">
                                            <i class="icon-user-follow"></i>
                                            <span class="title">Perfil</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/users/create" class="nav-link nav-toggle">
                                            <i class="icon-user-follow"></i>
                                            <span class="title">Crear Novo</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/users/{{Auth::user()['id']}}/edit" class="nav-link nav-toggle">
                                            <i class="icon-user"></i>
                                            <span class="title">Editar Informações</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/users/passport" class="nav-link nav-toggle">
                                            <i class="icon-user"></i>
                                            <span class="title">Passport API Keys</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                              
                     
                                </ul>
                            </li>

                            <li class="nav-item ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-bullhorn"></i>
                                    <span class="title">Ayuda</span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="/help" class="nav-link nav-toggle">
                                            <i class="fa fa-bullhorn"></i>
                                            <span class="title">Productos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/help" class="nav-link nav-toggle">
                                            <i class="fa fa-bullhorn"></i>
                                            <span class="title">Representativos</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/help" class="nav-link nav-toggle">
                                            <i class="fa fa-bullhorn"></i>
                                            <span class="title">Mi Perfil</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>



                                </ul>
                            </li>






                         
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->