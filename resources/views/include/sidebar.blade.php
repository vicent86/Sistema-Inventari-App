<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ url('images/user.png') }}" width="60" height="60" alt="User" />
        </div>
        <div class="info-container">
            @if(Auth::check())
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
                <div class="email">{{ Auth::user()->email  }}</div>
            @endif
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ url('password-change') }}"><i class="material-icons">person</i>Perfil</a></li>
                    <li><a href="{{ url('logout') }}"><i class="material-icons">input</i>Desconectar</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">NAVEGACIÓN PRINCIPAL</li>
            <li @if(Route::currentRouteName()=='' ) class="active" @endif>
                <a href="{{ url('/') }}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>

            @php

                $side_menu = \Illuminate\Support\Facades\Session::get('side_menu', []);

            @endphp

            @if(!is_null($side_menu) && array_key_exists(0,$side_menu))

                @foreach($side_menu[0] as $value)

                    @if(count($value['sub_menu'])>0)
                        <li class="parent">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">{{ $value['icon'] }}</i>
                                <span>{{ $value['name'] }}</span>
                            </a>
                            <ul class="ml-menu">

                                @foreach($value['sub_menu'] as $sub)
                                    <li @if(Route::currentRouteName()==$sub->menu_url) class="active" @endif>
                                        <a href="{{ $sub->menu_url ? route($sub->menu_url) : '' }}">
                                            <span>{{ $sub->name }}</span>
                                        </a>

                                    </li>
                                @endforeach

                            </ul>
                        </li>

                    @else

                        <li @if(Route::currentRouteName()==$value['url']) class="active" @endif>
                            <a href="{{ $value['url'] ? route($value['url']) : '' }}">
                                <i class="material-icons">{{ $value['icon'] }}</i>
                                <span>{{ $value['name'] }}</span>
                            </a>
                        </li>

                    @endif

                @endforeach()

            @endif

        </ul>
    </div>

</aside>
<!-- #END# Left Sidebar -->
