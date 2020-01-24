
<!-- Topbar -->
<header class="topbar">
    <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>

        <a class="topbar-btn d-none d-md-block" href="#" data-provide="fullscreen tooltip" title="Fullscreen">
            <i class="material-icons fullscreen-default">fullscreen</i>
            <i class="material-icons fullscreen-active">fullscreen_exit</i>
        </a>
    </div>

    <div class="topbar-right">

        <div class="topbar-divider"></div>

        <ul class="topbar-btns">
            <li class="dropdown">
                <span class="topbar-btn" data-toggle="dropdown">
                    <img class="avatar" src="{{asset('assets/img/avatar/1.jpg')}}">
                    <span class="text-default fw-200 ml-2">{{Auth::user()->getName()}}</span>
                </span>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('profile.my')}}"><i class="ti-user"></i> Perfil</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePassword"><i class="ti-key"></i> Mudar Senha</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="ti-power-off"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>

            <!-- Notifications -->
            <li class="dropdown d-none d-md-block">

                <span class="topbar-btn @if(Auth::user()->hasUnreadNotifications()) has-new @endif" data-toggle="dropdown"><i class="ti-bell"></i></span>

                <div class="dropdown-menu dropdown-menu-right">

                    <div class="media-list media-list-hover media-list-divided media-list-xs">

                        @foreach(Auth::user()->getTopBarNotifications() as $notification)
                            <a class="media" href="{{route('notifications.index')}}">
                                <span class="avatar bg-warning"><i class="ti-time"></i></span>
                                <div class="media-body">
                                    <p>{{$notification->data['description']}}</p>
                                    <time datetime="2017-07-14 20:00">{{$notification->created_at->diffForHumans()}}</time>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="dropdown-footer">
                        <div class="left">
                            <a href="{{route('notifications.index')}}">Ver todas notificações</a>
                        </div>

                        {{--<div class="right">--}}
                            {{--<a href="#" data-provide="tooltip" title="Mark all as read"><i class="fa fa-circle-o"></i></a>--}}
                            {{--<a href="#" data-provide="tooltip" title="Update"><i class="fa fa-repeat"></i></a>--}}
                            {{--<a href="#" data-provide="tooltip" title="Settings"><i class="fa fa-gear"></i></a>--}}
                        {{--</div>--}}
                    </div>

                </div>
            </li>
            <!-- END Notifications -->


        </ul>

    </div>
</header>
<!-- END Topbar -->
