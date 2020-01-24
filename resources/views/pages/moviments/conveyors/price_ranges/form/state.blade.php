
<h5 class=""><strong>Escolha o estado</strong></h5>
<div class="form-row">
    <div class="form-group col-md-8">
        {{Form::select('state_price', $Page->auxiliar['states'], "", ['placeholder' => 'Escolha o Estado', 'class'=>'form-control', 'required'])}}
    </div>
    <div class="form-group col-md-4">
        <footer class=" text-right">
            <button class="btn btn-default btn-block" onclick="selectAllCities()" type="button"><i class="ti ti-check-box"></i>Selecionar Todas as Cidades</button>
        </footer>
    </div>
</div>