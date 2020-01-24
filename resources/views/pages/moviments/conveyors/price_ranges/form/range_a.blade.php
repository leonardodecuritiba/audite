{{Form::open(array(
        'route' => ['conveyors.price-range-a.add-cities', $Data->id],
        'method'=>'POST',
        'data-provide'=> "validation",
        'data-disable'=>'false'
    ))}}
<h4 class="card-title"><strong>Adicionar Localidades Atendidas</strong></h4>

<div class="card-body">

    <h5 class=""><strong>Coleta</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_a_c', '10Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_a_c', '0,00', ['placeholder' => '10Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_b_c', '20Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_b_c', '0,00', ['placeholder' => '20Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_c_c', '30Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_c_c', '0,00', ['placeholder' => '30Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_d_c', '50Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_d_c', '0,00', ['placeholder' => '50Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_e_c', '70Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_e_c', '0,00', ['placeholder' => '70Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_f_c', '100Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_f_c', '0,00', ['placeholder' => '100Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('excess_c', 'Excedente *', array('class' => 'col-form-label'))) !!}
            {{Form::text('excess_c', '0,00', ['placeholder' => 'Excedente', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <h5 class=""><strong>Entrega</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_a_d', '10Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_a_d', '0,00', ['placeholder' => '10Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_b_d', '20Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_b_d', '0,00', ['placeholder' => '20Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_c_d', '30Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_c_d', '0,00', ['placeholder' => '30Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_d_d', '50Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_d_d', '0,00', ['placeholder' => '50Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_e_d', '70Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_e_d', '0,00', ['placeholder' => '70Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-1">
            {!! Html::decode(Form::label('value_f_d', '100Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_f_d', '0,00', ['placeholder' => '100Kg', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('excess_d', 'Excedente *', array('class' => 'col-form-label'))) !!}
            {{Form::text('excess_d', '0,00', ['placeholder' => 'Excedente', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    @include('pages.moviments.conveyors.price_ranges.form.state')

</div>