<a class="nav-link  @if(Route::currentRouteName() == $entity.'.index') active @endif" href="{{route($entity.'.index')}}">LISTAR - EDITAR</a>
<a class="nav-link  @if(Route::currentRouteName() == $entity.'.create') active @endif" href="{{route($entity.'.create')}}">CADASTRAR</a>
@if(isset($removeds) && $removeds)
    <a class="nav-link  @if(Route::currentRouteName() == $entity.'.removeds') active @endif" href="{{route($entity.'.removeds')}}">REMOVIDOS</a>
@endif