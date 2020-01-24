@extends('auth.app')
@section('body_content')

    @include('layout.inc.alerts')
    <div class="col-12">
        <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
            <h5 class="text-uppercase">{{ config('app.name', 'SystemPaulista') }}</h5>
            <br>
            <h4>Recuperar Senha</h4>
            <p>
                <small>Mandaremos um email com a sua senha!</small>
            </p>

            <form class="form-horizontal" data-provide="validation" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    <div class="invalid-feedback"></div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <br>
                <button class="btn btn-bold btn-block btn-info" type="submit">Recuperar</button>
            </form>
            <p class="text-center text-muted fs-13 mt-20">ou clique em <a class="text-info fw-500"
                                                                          href="{{route('login')}}">Entrar</a>

        </div>
    </div>
@endsection
