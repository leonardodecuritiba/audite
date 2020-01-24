

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->


<div class="card-body">

    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('plate', 'Placa', array('class' => 'col-form-label'))) !!}
            {{Form::text('plate', old('plate',(isset($Data) ? $Data->plate : "")), ['id'=>'plate','placeholder'=>'Placa','class'=>'form-control show-plate','minlength'=>'8', 'maxlength'=>'8', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('contract_type', 'Tipo de Contrato', array('class' => 'col-form-label'))) !!}
            {{Form::select('contract_type', $Page->auxiliar['contract_types'], old('contract_type',(isset($Data) ? $Data->contract_type : "")), ['placeholder' => 'Escolha o Tipo de Contrato', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('vehicle_type', 'Tipo de Veículo', array('class' => 'col-form-label'))) !!}
            {{Form::select('vehicle_type', $Page->auxiliar['vehicle_types'], old('vehicle_type',(isset($Data) ? $Data->vehicle_type : "")), ['placeholder' => 'Escolha o Tipo de Veículo', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('owner_type', 'Tipo do Proprietário', array('class' => 'col-form-label'))) !!}
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="owner_type" value="0" @if(isset($Data) && $Data->isOwnerLegalPerson()) checked="" @endif>
                <label class="custom-control-label" for="type">Pessoa Física</label>
            </div>

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="owner_type" value="1" id="juridico" @if(!isset($Data)) checked="" @elseif(!$Data->isOwnerLegalPerson())  checked=""  @endif>
                <label class="custom-control-label" for="type">Pessoa Jurídica</label>
            </div>
        </div>
        <div class="form-group col-md-5">
            {!! Html::decode(Form::label('owner_name', 'Nome do Proprietário', array('class' => 'col-form-label'))) !!}
            {{Form::text('owner_name', old('owner_name',(isset($Data) ? $Data->owner_name : "")), ['id'=>'owner_name','placeholder'=>'Nome do Proprietário','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4 section-pj">
            {!! Html::decode(Form::label('owner_cnpj', 'CNPJ *', array('class' => 'col-form-label'))) !!}
            {{Form::text('owner_cnpj', old('owner_cnpj',(isset($Data) ? $Data->owner_cnpj_formatted : "")), ['id'=>'owner_cnpj','placeholder'=>'CNPJ','class'=>'form-control show-cnpj','minlength'=>'3', 'maxlength'=>'60', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4 section-pf">
            {!! Html::decode(Form::label('owner_cpf', 'CPF *', array('class' => 'col-form-label'))) !!}
            {{Form::text('owner_cpf', old('owner_cpf',(isset($Data) ? $Data->owner_cpf_formatted : "")), ['id'=>'owner_cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'16'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('driver_type', 'Tipo do Motorista', array('class' => 'col-form-label'))) !!}
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="driver_type" value="0" @if(isset($Data) && $Data->isDriverLegalPerson()) checked="" @endif>
                <label class="custom-control-label" for="type">Pessoa Física</label>
            </div>

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="driver_type" value="1" id="juridico" @if(!isset($Data)) checked="" @elseif(!$Data->isDriverLegalPerson())  checked=""  @endif>
                <label class="custom-control-label" for="type">Pessoa Jurídica</label>
            </div>
        </div>

        <div class="form-group col-md-5">
            {!! Html::decode(Form::label('driver_name', 'Nome do Motorista', array('class' => 'col-form-label'))) !!}
            {{Form::text('driver_name', old('driver_name',(isset($Data) ? $Data->driver_name : "")), ['id'=>'driver_name','placeholder'=>'Nome do Motorista','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4 section-pj">
            {!! Html::decode(Form::label('driver_cnpj', 'CNPJ *', array('class' => 'col-form-label'))) !!}
            {{Form::text('driver_cnpj', old('driver_cnpj',(isset($Data) ? $Data->driver_cnpj_formatted : "")), ['id'=>'driver_cnpj','placeholder'=>'CNPJ','class'=>'form-control show-cnpj','minlength'=>'3', 'maxlength'=>'60', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4 section-pf">
            {!! Html::decode(Form::label('driver_cpf', 'CPF *', array('class' => 'col-form-label'))) !!}
            {{Form::text('driver_cpf', old('driver_cpf',(isset($Data) ? $Data->driver_cpf_formatted : "")), ['id'=>'driver_cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'16'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('brand', 'Marca', array('class' => 'col-form-label'))) !!}
            {{Form::text('brand', old('brand',(isset($Data) ? $Data->brand : "")), ['id'=>'brand','placeholder'=>'Marca','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('model', 'Modelo', array('class' => 'col-form-label'))) !!}
            {{Form::text('model', old('model',(isset($Data) ? $Data->model : "")), ['id'=>'model','placeholder'=>'Modelo','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('bodywork_type', 'Tipo de Carroceria', array('class' => 'col-form-label'))) !!}
            {{Form::select('bodywork_type', $Page->auxiliar['bodywork_types'], old('bodywork_type',(isset($Data) ? $Data->bodywork_type : "")), ['placeholder' => 'Escolha o Tipo de Carroceria', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('capacity', 'Capacidade', array('class' => 'col-form-label'))) !!}
            {{Form::text('capacity', old('capacity',(isset($Data) ? $Data->capacity : "")), ['id'=>'capacity','maxlength'=>9,'placeholder'=>'Capacidade','class'=>'form-control show-int'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


