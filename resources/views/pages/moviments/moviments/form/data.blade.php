

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->


<div class="card-body">

    <div class="form-row">

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('ctrc', 'CTRC', array('class' => 'col-form-label'))) !!}
            {{Form::text('ctrc', old('ctrc',(isset($Data) ? $Data->ctrc : "")), ['placeholder'=>'CTRC','class'=>'form-control', 'maxlength'=>'20', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cte_number', 'Número CT-e', array('class' => 'col-form-label'))) !!}
            {{Form::text('cte_number', old('cte_number',(isset($Data) ? $Data->cte_number : "")), ['placeholder'=>'Número CT-e','class'=>'form-control', 'maxlength'=>'20', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('document_type', 'Tipo de Documento', array('class' => 'col-form-label'))) !!}
            {{Form::select('document_type', $Page->auxiliar['document_types'], old('document_type',(isset($Data) ? $Data->document_type : "")), ['placeholder' => '', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('emitted_at', 'Data de Emissão', array('class' => 'col-form-label'))) !!}
            {{Form::text('emitted_at', old('emitted_at',(isset($Data) ? $Data->emitted_at_formatted : "")), ['placeholder'=>'Data de Emissão','class'=>'form-control show-datetime', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('cte_key', 'Chave CTe', array('class' => 'col-form-label'))) !!}
            {{Form::text('cte_key', old('cte_key',(isset($Data) ? $Data->cte_key : "")), ['placeholder'=>'Chave CTe','class'=>'form-control', 'maxlength'=>'60', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('sender_id', 'Cliente Remetente', array('class' => 'col-form-label'))) !!}
            {{Form::select('sender_id', isset($Data) ? $Page->auxiliar['sender'] : [], old('sender_id',(isset($Data) ? $Data->sender_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cnpj_sender', 'CNPJ', array('class' => 'col-form-label'))) !!}
            {{Form::text('cnpj_sender', old('cnpj_sender',(isset($Data) ? $Data->sender->cnpj_formatted : "")), ['placeholder'=>'Selecione o Remetente','class'=>'form-control', 'maxlength'=>'60', 'disabled'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('dispatcher_id', 'Cliente Expedidor', array('class' => 'col-form-label'))) !!}
            {{Form::select('dispatcher_id', isset($Data) ? $Page->auxiliar['dispatcher'] : [], old('dispatcher_id',(isset($Data) ? $Data->dispatcher_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cnpj_dispatcher', 'CNPJ', array('class' => 'col-form-label'))) !!}
            {{Form::text('cnpj_dispatcher', old('cnpj_dispatcher',(isset($Data) ? $Data->dispatcher->cnpj_formatted : "")), ['placeholder'=>'Selecione o Expedidor','class'=>'form-control', 'maxlength'=>'60', 'disabled'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('payer_id', 'Cliente Pagador', array('class' => 'col-form-label'))) !!}
            {{Form::select('payer_id', isset($Data) ? $Page->auxiliar['payer'] : [], old('payer_id',(isset($Data) ? $Data->payer_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cnpj_payer', 'CNPJ', array('class' => 'col-form-label'))) !!}
            {{Form::text('cnpj_payer', old('cnpj_payer',(isset($Data) ? $Data->payer->cnpj_formatted : "")), ['placeholder'=>'Selecione o Pagador','class'=>'form-control', 'maxlength'=>'60', 'disabled'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('receiver_id', 'Cliente Destinatário', array('class' => 'col-form-label'))) !!}
            {{Form::select('receiver_id', isset($Data) ? $Page->auxiliar['receiver'] : [], old('receiver_id',(isset($Data) ? $Data->receiver_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cnpj_receiver', 'CNPJ', array('class' => 'col-form-label'))) !!}
            {{Form::text('cnpj_receiver', old('cnpj_receiver',(isset($Data) ? $Data->receiver->cnpj_formatted : "")), ['placeholder'=>'Selecione o Destinatário','class'=>'form-control', 'maxlength'=>'60', 'disabled'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>


    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('partner', 'Parceiro', array('class' => 'col-form-label'))) !!}
            {{Form::text('partner', old('partner',(isset($Data) ? $Data->partner->getName() : "")), ['placeholder'=>'Parceiro','class'=>'form-control', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('destiny_unity', 'Unidade Destino', array('class' => 'col-form-label'))) !!}
            {{Form::text('destiny_unity', old('destiny_unity',(isset($Data) ? $Data->destiny_unity : "")), ['placeholder'=>'Unidade Destino','class'=>'form-control', 'maxlength'=>'100', 'disabled'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('real_weight', 'Peso Real em Kg', array('class' => 'col-form-label'))) !!}
            {{Form::text('real_weight', old('real_weight',(isset($Data) ? $Data->real_weight_formatted : "")), ['placeholder'=>'Peso Real em Kg','class'=>'form-control show-weight', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cubage', 'Cubagem em m³', array('class' => 'col-form-label'))) !!}
            {{Form::text('cubage', old('cubage',(isset($Data) ? $Data->cubage_formatted : "")), ['placeholder'=>'Cubagem em m3','class'=>'form-control show-length', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('volume_quantity', 'Quantidade de Vol.', array('class' => 'col-form-label'))) !!}
            {{Form::text('volume_quantity', old('volume_quantity',(isset($Data) ? $Data->volume_quantity : "")), ['placeholder'=>'Quantidade de Vol.','class'=>'form-control show-int', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('freight', 'Tipo do Frete', array('class' => 'col-form-label'))) !!}
            {{Form::select('freight', $Page->auxiliar['moviment_freights'], old('freight',(isset($Data) ? $Data->freight : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            {!! Html::decode(Form::label('commodity_id', 'Mercadoria', array('class' => 'col-form-label'))) !!}
            {{Form::select('commodity_id', $Page->auxiliar['commodities'], old('commodity_id',(isset($Data) ? $Data->commodity_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('specie_id', 'Espécie', array('class' => 'col-form-label'))) !!}
            {{Form::select('specie_id', $Page->auxiliar['species'], old('specie_id',(isset($Data) ? $Data->specie_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('value', 'Valor da Mercadoria', array('class' => 'col-form-label'))) !!}
            {{Form::text('value', old('value',(isset($Data) ? $Data->value_formatted : "")), ['placeholder'=>'Valor da Mercadoria','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('calculus_type', 'Tipo de Cálculo', array('class' => 'col-form-label'))) !!}
            {{Form::select('calculus_type', $Page->auxiliar['calculus_types'], old('calculus_type',(isset($Data) ? $Data->calculus_type : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('calculus_table', 'Tabela de Cálculo', array('class' => 'col-form-label'))) !!}
            {{Form::text('calculus_table', old('calculus_table',(isset($Data) ? $Data->calculus_table : "")), ['placeholder'=>'Tabela de Cálculo','class'=>'form-control', 'maxlength'=>'20'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('freight_value', 'Valor do Frete', array('class' => 'col-form-label'))) !!}
            {{Form::text('freight_value', old('freight_value',(isset($Data) ? $Data->freight_value_formatted : "")), ['placeholder'=>'Valor do Frete','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('freight_icms', 'Valor do Frete sem ICMS', array('class' => 'col-form-label'))) !!}
            {{Form::text('freight_icms', old('freight_icms',(isset($Data) ? $Data->freight_icms_formatted : "")), ['placeholder'=>'Valor do Frete sem ICMS','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('calculus_basis', 'Base de Calculo', array('class' => 'col-form-label'))) !!}
            {{Form::text('calculus_basis', old('calculus_basis',(isset($Data) ? $Data->calculus_basis_formatted : "")), ['placeholder'=>'Base de Calculo','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('icms_value', 'Valor do ICMS', array('class' => 'col-form-label'))) !!}
            {{Form::text('icms_value', old('icms_value',(isset($Data) ? $Data->icms_value_formatted : "")), ['placeholder'=>'Valor do ICMS','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('aliquot', 'Aliquota', array('class' => 'col-form-label'))) !!}
            {{Form::text('aliquot', old('aliquot',(isset($Data) ? $Data->aliquot_formatted : "")), ['placeholder'=>'Aliquota','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('iss_value', 'Valor do ISS', array('class' => 'col-form-label'))) !!}
            {{Form::text('iss_value', old('iss_value',(isset($Data) ? $Data->iss_value_formatted : "")), ['placeholder'=>'Valor do Frete sem ICMS','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('weight_calculated', 'Peso Calculado em Kg', array('class' => 'col-form-label'))) !!}
            {{Form::text('weight_calculated', old('weight_calculated',(isset($Data) ? $Data->weight_calculated_formatted : "")), ['placeholder'=>'Peso Real em Kg','class'=>'form-control show-weight', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>


        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('modality_id', 'Modalidade', array('class' => 'col-form-label'))) !!}
            {{Form::select('modality_id', $Page->auxiliar['modalities'], old('modality_id',(isset($Data) ? $Data->modality_id : "")), ['placeholder' => '', 'class'=>'form-control select2_single', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('weight_freight', 'Frete Peso', array('class' => 'col-form-label'))) !!}
            {{Form::text('weight_freight', old('weight_freight',(isset($Data) ? $Data->weight_freight_formatted : "")), ['placeholder'=>'Base de Calculo','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('value_freight', 'Frete Valor', array('class' => 'col-form-label'))) !!}
            {{Form::text('value_freight', old('value_freight',(isset($Data) ? $Data->value_freight_formatted : "")), ['placeholder'=>'Frete Valor','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('despatch', 'Despacho', array('class' => 'col-form-label'))) !!}
            {{Form::text('despatch', old('despatch',(isset($Data) ? $Data->despatch_formatted : "")), ['placeholder'=>'Despacho','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cat', 'CAT', array('class' => 'col-form-label'))) !!}
            {{Form::text('cat', old('cat',(isset($Data) ? $Data->cat_formatted : "")), ['placeholder'=>'CAT','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('itr', 'ITR', array('class' => 'col-form-label'))) !!}
            {{Form::text('itr', old('itr',(isset($Data) ? $Data->itr_formatted : "")), ['placeholder'=>'ITR','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('gris', 'GRIS', array('class' => 'col-form-label'))) !!}
            {{Form::text('gris', old('gris',(isset($Data) ? $Data->gris_formatted : "")), ['placeholder'=>'GRIS','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('toll', 'Pedagio', array('class' => 'col-form-label'))) !!}
            {{Form::text('toll', old('toll',(isset($Data) ? $Data->toll_formatted : "")), ['placeholder'=>'Pedagio','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('tas', 'TAS', array('class' => 'col-form-label'))) !!}
            {{Form::text('tas', old('tas',(isset($Data) ? $Data->tas_formatted : "")), ['placeholder'=>'TAS','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('tda', 'TDA', array('class' => 'col-form-label'))) !!}
            {{Form::text('tda', old('tda',(isset($Data) ? $Data->tda_formatted : "")), ['placeholder'=>'TDA','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('suframa', 'Suframa', array('class' => 'col-form-label'))) !!}
            {{Form::text('suframa', old('suframa',(isset($Data) ? $Data->suframa_formatted : "")), ['placeholder'=>'Suframa','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('others', 'Outros', array('class' => 'col-form-label'))) !!}
            {{Form::text('others', old('others',(isset($Data) ? $Data->others_formatted : "")), ['placeholder'=>'Outros','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('collect', 'Coleta', array('class' => 'col-form-label'))) !!}
            {{Form::text('collect', old('collect',(isset($Data) ? $Data->collect_formatted : "")), ['placeholder'=>'Coleta','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('tdc', 'TDC', array('class' => 'col-form-label'))) !!}
            {{Form::text('tdc', old('tdc',(isset($Data) ? $Data->tdc_formatted : "")), ['placeholder'=>'TDC','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('tde', 'TDE', array('class' => 'col-form-label'))) !!}
            {{Form::text('tde', old('tde',(isset($Data) ? $Data->tde_formatted : "")), ['placeholder'=>'TDE','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('tar', 'TAR', array('class' => 'col-form-label'))) !!}
            {{Form::text('tar', old('tar',(isset($Data) ? $Data->tar_formatted : "")), ['placeholder'=>'TAR','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('trt', 'TRT', array('class' => 'col-form-label'))) !!}
            {{Form::text('trt', old('trt',(isset($Data) ? $Data->trt_formatted : "")), ['placeholder'=>'TRT','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('first_manifest', 'Primeiro Manifesto', array('class' => 'col-form-label'))) !!}
            {{Form::text('first_manifest', old('first_manifest',(isset($Data) ? $Data->first_manifest : "")), ['placeholder'=>'Primeiro Manifesto','class'=>'form-control', 'maxlength'=>20])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('first_manifested_at', 'Data do Primeiro Manifesto', array('class' => 'col-form-label'))) !!}
            {{Form::text('first_manifested_at', old('first_manifested_at',(isset($Data) ? $Data->first_manifested_at_formatted : "")),['placeholder'=>'Data do Primeiro Manifesto', 'class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('horse', 'Placa do Cavalo', array('class' => 'col-form-label'))) !!}
            {{Form::text('horse', old('horse_id',(isset($Data) ? optional($Data->horse)->plate_formatted : "")), ['placeholder'=>'Placa do Cavalo','class'=>'form-control show-plate'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cart', 'Placa da Carreta', array('class' => 'col-form-label'))) !!}
            {{Form::text('cart', old('cart',(isset($Data) ? optional($Data->cart)->plate_formatted : "")), ['placeholder'=>'Placa da Carreta','class'=>'form-control show-plate'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('last_manifest', 'Último Manifesto', array('class' => 'col-form-label'))) !!}
            {{Form::text('last_manifest', old('last_manifest',(isset($Data) ? $Data->last_manifest : "")), ['placeholder'=>'Último Manifesto','class'=>'form-control', 'maxlength'=>20])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('last_manifested_at', 'Data do Último Manifesto', array('class' => 'col-form-label'))) !!}
            {{Form::text('last_manifested_at', old('last_manifested_at',(isset($Data) ? $Data->last_manifested_at_formatted : "")), ['placeholder'=>'Data do Último Manifesto','class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('last_cargo', 'Último Romaneio', array('class' => 'col-form-label'))) !!}
            {{Form::text('last_cargo', old('last_cargo',(isset($Data) ? $Data->last_cargo : "")), ['placeholder'=>'Primeiro Romaneio','class'=>'form-control', 'maxlength'=>20])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('last_cargo_at', 'Data do Último Romaneio', array('class' => 'col-form-label'))) !!}
            {{Form::text('last_cargo_at', old('last_cargo_at',(isset($Data) ? $Data->last_cargo_at_formatted : "")), ['placeholder'=>'Data do Último Romaneio','class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('deliver', 'Placa de Entrega', array('class' => 'col-form-label'))) !!}
            {{Form::text('deliver', old('deliver',(isset($Data) ? optional($Data->deliver)->plate_formatted : "")), ['placeholder'=>'Placa de Entrega','class'=>'form-control show-plate'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('last_occurrence_code', 'Código da Última Ocorrência', array('class' => 'col-form-label'))) !!}
            {{Form::text('last_occurrence_code', old('last_occurrence_code',(isset($Data) ? $Data->last_occurrence_code : "")), ['placeholder'=>'Código da Última Ocorrência','class'=>'form-control show-int', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('delivery_prevision', 'Previsão de Entrega', array('class' => 'col-form-label'))) !!}
            {{Form::text('delivery_prevision', old('delivery_prevision',(isset($Data) ? $Data->delivery_prevision_formatted : "")), ['placeholder'=>'Previsão de Entrega','class'=>'form-control show-date', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('delivered_at', 'Data da Entrega Realizada', array('class' => 'col-form-label'))) !!}
            {{Form::text('delivered_at', old('delivered_at',(isset($Data) ? $Data->delivered_at_formatted : "")), ['placeholder'=>'Data da Entrega Realizada','class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('canceled_at', 'Data do Cancelamento', array('class' => 'col-form-label'))) !!}
            {{Form::text('canceled_at', old('canceled_at',(isset($Data) ? $Data->canceled_at_formatted : "")), ['placeholder'=>'Data do Cancelamento','class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('canceled_reason', 'Motivo do Cancelamento', array('class' => 'col-form-label'))) !!}
            {{Form::text('canceled_reason', old('canceled_reason',(isset($Data) ? $Data->canceled_reason : "")), ['placeholder'=>'Motivo do Cancelamento','class'=>'form-control','maxlength'=>500])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('request_number', 'Número dos Pedidos', array('class' => 'col-form-label'))) !!}
            {{Form::text('request_number', old('request_number',(isset($Data) ? $Data->request_number : "")), ['placeholder'=>'Número dos Pedidos','class'=>'form-control','maxlength'=>10])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

</div>



<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


