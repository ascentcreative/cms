@extends('cms::admin.base')

@section('pagebody')

<div class="flex flex-center flex-align-center" style="height: 80vh; flex-direction: column">

    <div style="width: 200px; margin: 20px; text-align: center">
    @includeFirst(['admin.login.header', 'cms::admin.login.header'])
    </div>

   
    <div class="auth-formpanel formpanel border-top">


     <div class="p-2 mt-3 mb-3 border rounded bg-white font-medium text-sm">
        @if (session('status'))
       
           {!! session('status') !!}
       @else
           Enter your email address to receive a password reset email.
       @endif
       </div>

    </div>

    <div class="auth-formpanel formpanel border-top">


        <form action="/forgot-password" method="POST">

            @csrf

            <div class="pt-3">
            <x-cms-form-input type="text" name="email" label="Email" value="{{ old('email','') }}" wrapper="simple"/>
            </div>

             {{-- <x-cms-form-input type="text" name="email" label="Email" value="{{ old('email','') }}" wrapper="simple"/> --}}
   

            <div class="text-center p-4">
                <x-cms-form-button name="reset" label="Reset Password" value="" wrapper="none" class="button btn-primary btn"/>
            </div>

        </form>

        
    </div>



@endsection