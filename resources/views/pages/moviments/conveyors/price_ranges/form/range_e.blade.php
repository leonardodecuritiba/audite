{{Form::open(array(
        'route' => ['conveyors.price-range-e.add-cities', $Data->id],
        'method'=>'POST',
        'data-provide'=> "validation",
        'data-disable'=>'false'
    ))}}
<h4 class="card-title"><strong>Adicionar Localidades Atendidas</strong></h4>

<div class="card-body">
    <h5 class=""><strong>Coleta</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('value_c', 'Mínimo *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_c', '0,00', ['placeholder' => 'Taxa Fixa', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('excess_c', 'Excedente %NF *', array('class' => 'col-form-label'))) !!}
            {{Form::text('excess_c', '0,00', ['placeholder' => 'Excedente %NF', 'class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <h5 class=""><strong>Entrega</strong></h5>
    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('value_d', 'Mínimo *', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_d', '0,00', ['placeholder' => 'Taxa Fixa', 'class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('excess_d', 'Excedente %NF *', array('class' => 'col-form-label'))) !!}
            {{Form::text('excess_d', '0,00', ['placeholder' => 'Excedente %NF', 'class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    @include('pages.moviments.conveyors.price_ranges.form.state')

</div>