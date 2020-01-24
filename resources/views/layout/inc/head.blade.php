<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

<!-- Bootstrap Core Css -->
{{Html::style('assets/css/core.min.css')}}

<!-- Waves Effect Css -->
{{Html::style('assets/css/app.min.css')}}

<!-- Animation Css -->
{{Html::style('assets/css/style.min.css')}}

<!-- Favicons -->
<link rel="apple-touch-icon" href="{{asset('assets/img/apple-touch-icon.png')}}">
<link rel="icon" href="{{asset('icon.png')}}">

<style>
    .material-icons {
        font-size: 20px !important;
    }
    .hidex {
        display: none !important;
    }
    .help-block {
        color: red;
    }
    .btn-a {
        color: white !important;
    }

    .header-info {
        margin: 10px 0;
    }
    .header-title small {
        padding-top: 0;
    }
    .header-action .nav-link {
        padding: 0rem 1rem 0rem;
    }
    .header {
        margin-bottom: 0;
    }
</style>

<!-- Select2 -->
@include('layout.inc.select2.css')

<!--WaitMe Css-->
@yield('style_content')
