<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{--<meta name="description" content="Responsive admin dashboard and web application ui kit. A highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.">--}}
    {{--<meta name="keywords" content="datatables">--}}

    <title>{{ config('app.name', 'SystemPaulista') }}</title>

    @include('layout.inc.head')
    <style>
        .help-block {
            color: red;
        }
    </style>
</head>
<body>


    @yield('body_content')

    @include('layout.inc.foot')

</body>
</html>
