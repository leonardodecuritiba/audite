<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{--<meta name="description" content="Responsive admin dashboard and web application ui kit. ">--}}
    {{--<meta name="keywords" content="lock, lockscreen">--}}

    <title>{{ config('app.name', 'SystemPaulista') }}</title>

    @include('layout.inc.head')

</head>

<body>

    <div class="row min-h-fullscreen center-vh p-20 m-0">

        @yield('body_content')

        <footer class="col-12 align-self-end text-center fs-13">
            <p class="mb-0"><small>Copyright © {{date('Y')}} <b>{{ config('app.name', 'SystemPaulista') }}</b>. Todos os direitos reservados.</small></p>
        </footer>
    </div>

    @include('layout.inc.foot')
</body>
</html>
