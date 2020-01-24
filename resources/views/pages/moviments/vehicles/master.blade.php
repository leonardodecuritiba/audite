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
                            'route' => ['vehicles.update', $Data->id],
                            'method'=>'PATCH',
                            'files'=>'true',
                            'data-provide'=> "validation",
                            'data-disable'=>'false'
                        )
                        )}}
                    @else
                        {{Form::open(array(
                            'route' => ['vehicles.store'],
                            'method'=>'POST',
                            'files'=>'true',
                            'data-provide'=> "validation",
                            'data-disable'=>'false'
                        )
                        )}}
                    @endif
                    @include('pages.moviments.vehicles.form.data')
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


    <!-- Jquery Maskmoney Plugin Js -->
    @include('layout.inc.maskmoney.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')



    <script>
        function toggleType($this, val) {

            var $parent = $($this).closest('div.form-row');
            var $div_pf = $($parent).find('div.section-pf');
            var $div_pj = $($parent).find('div.section-pj');

            if (val == "0") {
                // $('input[name="type"]#pf').prop('checked', true);
                $($div_pj).hide();
                $($div_pj).find('input').attr('required', false);
                $($div_pf).fadeIn('fast');
                $($div_pf).find('input').attr('required', true);
//                $('section.section-pj').find('input').val("");
            } else {
                $($div_pf).hide();
                $($div_pf).find('input').attr('required', false);
                $($div_pj).fadeIn('fast');
                $($div_pj).find('input').attr('required', true);
            }
        }

        $(document).ready(function () {
            $('input[name="owner_type"]').change(function () {
                toggleType($(this), $(this).val());
            });

            toggleType($('input[name="owner_type"]'), '{{isset($Data) ? $Data->owner_type : 1}}');

            $('input[name="driver_type"]').change(function () {
                toggleType($(this), $(this).val());
            });

            toggleType($('input[name="driver_type"]'), '{{isset($Data) ? $Data->driver_type : 1}}');
        });

    </script>

@endsection
