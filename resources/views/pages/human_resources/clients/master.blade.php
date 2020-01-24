@extends('layout.app')

@section('title', $Page->title)

@section('style_content')
    <!-- Bootstrap Select Css -->
    {{Html::style('bower_components/bootstrap-select/dist/css/bootstrap-select.css')}}
@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layout.inc.breadcrumb')

@endsection

@section('page_content')
    <!-- Main container -->
    <div class="main-content">


    @include('layout.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            @if(isset($Data))
                <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}}</strong></h4>
            @else
                <h4 class="card-title"><strong>Dados do {{$Page->name}}</strong></h4>
            @endif
            <div class="card-body">
                @if(isset($Data))
                    {{Form::model($Data,
                        array(
                            'route' => ['clients.update', $Data->id],
                            'method'=>'PATCH',
                            'files'=>'true',
                            'data-provide'=> "validation",
                            'data-disable'=>'false'
                        )
                        )}}
                    @else
                        {{Form::open(array(
                            'route' => ['clients.store'],
                            'method'=>'POST',
                            'files'=>'true',
                            'data-provide'=> "validation",
                            'data-disable'=>'false'
                        )
                        )}}
                    @endif
                    @include('pages.human_resources.clients.form.data')
                {{Form::close()}}
            </div>
        </div>
    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Jquery Validation Plugin Js -->
    @include('layout.inc.validation.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')

    <!-- LegalPeople Layout Js -->
    @include('layout.inc.legal_person.js')

    <!-- Address Layout Js -->
    @include('layout.inc.address.js')
@endsection
