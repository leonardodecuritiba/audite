<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}} ({{$Data->type_formatted}})</strong></h4>
@else
    <h4 class="card-title"><strong>Dados do Usuário</strong></h4>
@endif

<div class="card-body">

    <h6 class="text-uppercase mt-3">Dados de Acesso</h6>
    <hr class="hr-sm mb-2">

    @if(isset($Data))

        <div class="form-row">
            <label class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10">
                <p class="form-control-plaintext">{{$Data->id}}</p>
            </div>
        </div>
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <p class="form-control-plaintext">{{$Data->getEmail()}}</p>
            </div>
        </div>
        <div class="form-row pull-right">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#changePasswordUser">Alterar Senha</button>
        </div>
    @else

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Html::decode(Form::label('email', 'Email *', array('class' => 'col-form-label'))) !!}
                {{Form::email('email', '', ['id'=>'email','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group col-md-6">
                {!! Html::decode(Form::label('password', 'Senha *', array('class' => 'col-form-label'))) !!}
                {{Form::text('password', '', ['id'=>'password','placeholder'=>'Senha','class'=>'form-control','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
        </div>

    @endif


    <h6 class="text-uppercase mt-3">Dados Pessoais</h6>
    <hr class="hr-sm mb-2">
    @if((Entrust::hasRole('admin') || Entrust::hasRole('root')) && (Route::current()->getName() != 'profile.my'))

        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Html::decode(Form::label('role_id', 'Tipo de Usuário *', array('class' => 'col-form-label'))) !!}
                {{Form::select('role_id', $Page->auxiliar['roles'], old('role_id',(isset($Data) ? $Data->getRoleId() : "")), ['placeholder' => 'Escolha o Tipo de Usuário', 'class'=>'form-control show-tick', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
        </div>

    @endif
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'col-form-label'))) !!}
            {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['id'=>'name','placeholder'=>'Nome','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

</div>


<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>
