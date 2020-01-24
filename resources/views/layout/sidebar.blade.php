<!-- Sidebar -->
<aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-lg sidebar-expand-lg">
    <header class="sidebar-header">
        {{--<a class="logo-icon" href="{{route('index')}}"><img src="{{asset('assets/images/logo/logo.png')}}"--}}
                                                            {{--alt="logo icon"></a>--}}
        <span class="logo">
          <a href="{{route('index')}}">
              {{ config('app.name', 'Audite') }}
          </a>
        </span>
    </header>

    <nav class="sidebar-navigation">
        <ul class="menu menu-xs">
            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | INTELIGÊNCIA
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->
            <li class="menu-item @if(Menu::isRoute(['users.index','users.create','users.edit','clients.index','clients.create','clients.edit','cost_types.index','vehicles.index','vehicles.create','vehicles.edit','conveyors.index','conveyors.create','conveyors.edit'])) active open @endif">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-plus-circle"></span>
                    <span class="title">Cadastros</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">
                    <li class="menu-item @if(Menu::isRoute(['users.index','users.create','users.edit'])) active @endif">
                        <a class="menu-link" href="{{route('users.index')}}">
                            <span class="icon ti-user"></span>
                            <span class="title">Usuários</span>
                        </a>
                    </li>

                    <li class="menu-item @if(Menu::isRoute(['clients.index','clients.create','clients.edit'])) active @endif">
                        <a class="menu-link" href="{{route('clients.index')}}">
                            <span class="icon ti-user"></span>
                            <span class="title">Clientes</span>
                        </a>
                    </li>
                    
                    <li class="menu-divider"></li>

                    <li class="menu-item @if(Menu::isRoute(['cost_types.index'])) active @endif">
                        <a class="menu-link" href="{{route('cost_types.index')}}">
                            <span class="icon ti-receipt"></span>
                            <span class="title">Tipos de Custo</span>
                        </a>
                    </li>

                    <li class="menu-item @if(Menu::isRoute(['vehicles.index','vehicles.create','vehicles.edit'])) active @endif">
                        <a class="menu-link" href="{{route('vehicles.index')}}">
                            <span class="icon ti-car"></span>
                            <span class="title">Veículos</span>
                        </a>
                    </li>

                    <li class="menu-item @if(Menu::isRoute(['conveyors.index','conveyors.create','conveyors.edit'])) active @endif">
                        <a class="menu-link" href="{{route('conveyors.index')}}">
                            <span class="icon ti-truck"></span>
                            <span class="title">Transportadoras</span>
                        </a>
                    </li>

                </ul>

            </li>

            <li class="menu-item @if(Menu::isRoute(['moviments.index','moviments.create','moviments.edit'])) active @endif">
                <a class="menu-link" href="{{route('moviments.index')}}">
                    <span class="icon ti-package"></span>
                    <span class="title">Movimentos</span>
                </a>
            </li>

            <li class="menu-item @if(Menu::isRoute(['contracts.index','contracts.create','contracts.edit'])) active @endif">
                <a class="menu-link" href="{{route('contracts.index')}}">
                    <span class="icon ti-receipt"></span>
                    <span class="title">Contratos</span>
                </a>
            </li>

            <li class="menu-item @if(Menu::isRoute(['invoices.import'])) active @endif">
                <a class="menu-link" href="{{route('invoices.import')}}">
                    <span class="icon ti-cloud-up"></span>
                    <span class="title">Importar Faturas</span>
                </a>
            </li>

            <li class="menu-item @if(Menu::isRoute(['reports.cte', 'reports.nf', 'reports.cost'])) active open @endif">
                <a class="menu-link" href="#">
                    <span class="icon ti-bar-chart"></span>
                    <span class="title">Relatórios / Consultas</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">

                    <li class="menu-item @if(Menu::isRoute(['reports.cte'])) active @endif">
                        <a class="menu-link" href="{{route('reports.cte')}}">
                            <span class="icon ti-file"></span>
                            <span class="title">Custo por CTe</span>
                        </a>
                    </li>

                    <li class="menu-item @if(Menu::isRoute(['reports.nf'])) active @endif">
                        <a class="menu-link" href="{{route('reports.nf')}}">
                            <span class="icon ti-receipt"></span>
                            <span class="title">Custo por NF</span>
                        </a>
                    </li>

                    <li class="menu-item @if(Menu::isRoute(['reports.cost'])) active @endif">
                        <a class="menu-link" href="{{route('reports.cost')}}">
                            <span class="icon ti-agenda"></span>
                            <span class="title">Consulta de Custos</span>
                        </a>
                    </li>


                </ul>

            </li>

        </ul>
    </nav>

</aside>
<!-- END Sidebar -->
