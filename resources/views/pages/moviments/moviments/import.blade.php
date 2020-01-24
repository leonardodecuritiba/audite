@extends('layout.app')

@section('title', $Page->title)

@section('style_content')

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
                            'route' => ['moviments.update', $Data->id],
                            'method'=>'PATCH',
                            'files'=>'true',
                            'data-provide'=> "validation",
                            'data-disable'=>'false'
                        )
                        )}}
                @else
                    {{Form::open(array(
                        'route' => ['moviments.store'],
                        'method'=>'POST',
                        'files'=>'true',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}
                @endif
                @include('pages.moviments.moviments.form.data')
                {{Form::close()}}
            </div>
        </div>
    </div><!--/.main-content -->
@endsection


@section('script_content')

@endsection
