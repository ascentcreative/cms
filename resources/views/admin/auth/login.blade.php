@extends('cms::admin.base')

@section('pagebody')

    <div class="flex flex-center flex-align-center" style="height: 80vh; flex-direction: column">

        <div style="width: 200px; margin: 20px; text-align: center">
        @includeFirst(['admin.login.header', 'cms::admin.login.header'])
        </div>
       
        <div class="auth-formpanel formpanel border-top">

            <form action="/login" method="POST" id="form_login">

                @csrf

                <div class="pt-3 pb-3">
                <x-cms-form-input type="text" name="email" label="Email" value="{{ old('email','') }}" wrapper="simple"/>
                </div>

                <x-cms-form-input type="password" name="password" label="Password" value="{{ old('password','') }}" wrapper="simple"/>

                @if(env("APP_ENV") != "production")
                    <div class="alert alert-warning mt-4 text-center rounded border" role="alert">
                        <i class="bi-exclamation-triangle-fill"></i> You are logging into a development / staging site.
                    </div>
                @endif

                <div class="text-center p-4 pt-2">
                    <x-cms-form-button name="login" label="Log In" value="" wrapper="none" class="button btn-primary btn" />
                </div>

                @php $intended = request()->intended ?? (session('url.intended') ?? url()->current()); @endphp
                <input type="hidden" name="intended" value="{{ $intended }}" /> 
                
                <div class="passwordprompt small text-center border-top p-2">
                Forgotten your password? <A href="/forgot-password">Reset it here</A>
                </div>


            </form>
        </div>

    </div>

@endsection