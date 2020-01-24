

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->


<div class="card-body">

    <h6 class="text-uppercase mt-3">Tipo de Cadastro</h6>
    <hr class="hr-sm mb-2">

    <div class="form-row">
        <div class="custom-controls-stacked">

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="type" value="0" @if(isset($Data) && ($Data->isLegalPerson())) checked="" @endif>
                <label class="custom-control-label" for="type">Pessoa Física</label>
            </div>

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="type" value="1" id="juridico" @if(!isset($Data) || !$Data->isLegalPerson())  checked=""  @endif>
                <label class="custom-control-label" for="type">Pessoa Jurídica</label>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('name', 'Nome', array('class' => 'col-form-label'))) !!}
            {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['id'=>'name','placeholder'=>'Nome Responsável','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('cpf', 'CPF', array('class' => 'col-form-label'))) !!}
            {{Form::text('cpf', old('cpf',(isset($Data) ? $Data->cpf : "")), ['id'=>'cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'16'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <section class="section-pj">

        <h6 class="text-uppercase mt-3">Dados de Pessoa Jurídica</h6>
        <hr class="hr-sm mb-2">
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Html::decode(Form::label('cnpj', 'CNPJ *', array('class' => 'col-form-label'))) !!}
                {{Form::text('cnpj', old('cnpj',(isset($Data) ? $Data->cnpj : "")), ['id'=>'cnpj','placeholder'=>'CNPJ','class'=>'form-control show-cnpj','minlength'=>'3', 'maxlength'=>'60', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Html::decode(Form::label('social_reason', 'Razão Social *', array('class' => 'col-form-label'))) !!}
                {{Form::text('social_reason', old('social_reason',(isset($Data) ? $Data->social_reason : "")), ['id'=>'social_reason','placeholder'=>'Razão Social','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group col-md-6">
                {!! Html::decode(Form::label('fantasy_name', 'Nome Fantasia *', array('class' => 'col-form-label'))) !!}
                {{Form::text('fantasy_name', old('fantasy_name',(isset($Data) ? $Data->fantasy_name : "")), ['id'=>'fantasy_name','placeholder'=>'Nome Fantasia','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
        </div>

    </section>

    @include('pages.human_resources.forms.address', ['Address' => (isset($Data) ? $Data->address : NULL)])

    @include('pages.human_resources.forms.contact', ['Contact' => (isset($Data) ? $Data->contact : NULL)])

</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


