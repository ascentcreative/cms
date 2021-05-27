@extends('cms::admin.base')

@section('pagebody')

    <div class="flex flex-center flex-align-center" style="height: 80vh;">

        <div class="formpanel" style="width: 400px">

            <form action="/login" method="POST" id="form_login">

                @csrf

                <x-cms-form-input type="text" name="email" label="Email" value="{{ old('email','') }}" wrapper="simple"/>
                
                <x-cms-form-input type="password" name="password" label="Password" value="{{ old('password','') }}" wrapper="simple"/>

                <x-cms-form-button name="login" label="Log In" value="" wrapper="simple"/>

                @php $intended = request()->intended ?? (session('url.intended') ?? url()->current()); @endphp
                <input type="hidden" name="intended" value="{{ $intended }}" /> 
                
                <div class="passwordprompt small text-center border-bottom p-2">
                Forgotten your password? <A href="/forgot-password">Reset it here</A>
                </div>


            </form>
        </div>

    </div>

@endsection