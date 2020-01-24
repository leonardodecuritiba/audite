

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->


<div class="card-body">


    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('initials', 'Iniciais', array('class' => 'col-form-label'))) !!}
            {{Form::text('initials', old('initials',(isset($Data) ? $Data->initials : "")), ['id'=>'initials','placeholder'=>'Iniciais','class'=>'form-control','minlength'=>'1', 'maxlength'=>'3', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-8">
            {!! Html::decode(Form::label('social_reason', 'Razão Social', array('class' => 'col-form-label'))) !!}
            {{Form::text('social_reason', old('social_reason',(isset($Data) ? $Data->social_reason : "")), ['id'=>'social_reason','placeholder'=>'Razão Social','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('type', 'Tipo', array('class' => 'col-form-label'))) !!}
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="type" value="0" @if(isset($Data) && $Data->isLegalPerson()) checked="" @endif>
                <label class="custom-control-label" for="type">Pessoa Física</label>
            </div>

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="type" value="1" id="juridico" @if(!isset($Data)) checked="" @elseif(!$Data->isLegalPerson())  checked=""  @endif>
                <label class="custom-control-label" for="type">Pessoa Jurídica</label>
            </div>
        </div>

        <div class="form-group col-md-4 section-pj">
            {!! Html::decode(Form::label('cnpj', 'CNPJ *', array('class' => 'col-form-label'))) !!}
            {{Form::text('cnpj', old('cnpj',(isset($Data) ? $Data->cnpj_formatted : "")), ['id'=>'cnpj','placeholder'=>'CNPJ','class'=>'form-control show-cnpj','minlength'=>'3', 'maxlength'=>'60', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4 section-pf">
            {!! Html::decode(Form::label('cpf', 'CPF *', array('class' => 'col-form-label'))) !!}
            {{Form::text('cpf', old('cpf',(isset($Data) ? $Data->cpf_formatted : "")), ['id'=>'cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'16'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('ie', 'Insc. Estadual', array('class' => 'control-label'))) !!}
            {{Form::text('ie', old('ie',(isset($Data) ? $Data->ie : "")), ['id'=>'ie','class'=>'form-control show-ie','minlength'=>'3', 'maxlength'=>'20'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>



    @include('pages.human_resources.forms.address', ['Address' => (isset($Data) ? $Data->address : NULL)])

    @include('pages.human_resources.forms.contact', ['Contact' => (isset($Data) ? $Data->contact : NULL)])

</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


