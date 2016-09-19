<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title">
                <img src="/images/versato-logo-white.png" alt="Versato Calzados - Sistema Comercial" class="sidebar-logo">
            </a>
        </div>

        <div class="profile"><!--img_2 -->
            <div class="profile_pic">
                <img src="{{Auth::user()['photo']}}" alt="..." class="img-circle profile_img" style="border: 1px;">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{Auth::user()['name']}} {{Auth::user()['lastname']}}</h2>
            </div>
        </div>

        <div class="clearfix"></div>
        <br>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="clearfix"></div>
            
            <div class="menu_section">
                <h3>Dashboads</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/productsdashboard">Dashboard de Productos</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Produtos</h3>
                
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Linhas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/lines">Ver Todas</a></li>
                        <li><a href="/lines/create">Nova Linha</a></li>
                    </ul>
                </ul>
                
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Referências <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/references">Ver Todas</a></li>
                        <li><a href="/references/create">Nova Referência</a></li>
                    </ul>
                </ul>

                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Materiais <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/materials">Ver Todos</a></li>
                        <li><a href="/materials/create">Novo Material</a></li>
                    </ul>
                </ul>

                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Cores <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/colors">Ver Todas</a></li>
                        <li><a href="/colors/create">Nova Cor</a></li>
                    </ul>
                </ul>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Produtos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/producto">Ver Todos</a></li>
                        <li><a href="/producto/create">Nova Produto</a></li>
                    </ul>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Regiones</h3>
                
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Macro Regiones <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/macroregions">Ver Todas</a></li>
                        <li><a href="/macroregions/create">Crear</a></li>
                    </ul>
                </ul>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Macro Regiones <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/regions">Ver Todas</a></li>
                        <li><a href="/regions/create">Crear</a></li>
                    </ul>
                </ul>
            </div>


            <div class="menu_section">
                <h3>Sistema</h3>
                
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Usuários<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/profile">Perfil</a></li>
                        <li><a href="/users/create">Criar Novo</a></li>
                         <li><a href="/users/1/edit">Editar Informações</a></li>
                    </ul>
                </ul>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i> Ayuda <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="/help">Productos</a></li>
                        <li><a href="/help">Reprentativos</a></li>
                        <li><a href="/help">Mi Perfil</a></li>
                    </ul>
                </ul>
            </div>

        </div>

        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</div>