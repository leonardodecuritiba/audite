{{Form::open(array(
        'route' => ['conveyors.price-range-b.add-cities', $Data->id],
        'method'=>'POST',
        'data-provide'=> "validation",
        'data-disable'=>'false'
    ))}}
<h4 class="card-title"><strong>Adicionar Localidades Atendidas</strong></h4>

<div class="card-body">
    <h5 class=""><strong>Coleta</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('value_c', 'Até 30Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_c', '0,00', ['placeholder' => 'Até 30Kg', 'class'=>'form-control show-price', 'required'])}}
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

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('value_d', 'Até 30Kg *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_d', '0,00', ['placeholder' => 'Até 30Kg', 'class'=>'form-control show-price', 'required'])}}
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