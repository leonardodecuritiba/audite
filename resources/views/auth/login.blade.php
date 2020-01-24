@extends('auth.app')
@section('body_content')

    {{--@include('layout.extras.left')--}}
    @include('layout.inc.alerts')
    <div class="col-12">
        <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
            <h5 class="text-uppercase">{{ config('app.name', 'SystemPaulista') }}</h5>
            <br>

            <form class="form-horizontal" data-provide="validation" method="POST" action="{{ route('login') }}">
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

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback"></div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group flexbox flex-column flex-md-row">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"
                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label">Lembrar</label>
                    </div>

                    <a class="text-muted hover-primary fs-13 mt-2 mt-md-0" href="{{ route('password.request') }}">Forgot password?</a>
                </div>

                <div class="form-group">
                    <button class="btn btn-bold btn-block btn-primary" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
