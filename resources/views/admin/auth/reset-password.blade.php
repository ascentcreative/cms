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
           Check your email address is correct, and enter a new password below
       @endif
       </div>

    </div>

    <div class="auth-formpanel formpanel border-top" >

        <form action="/reset-password" method="POST">
            @csrf
            
            <div class="pt-3">
                <x-cms-form-input type="text" name="email" label="Email" value="{{ old('email', request()->email ) }}" wrapper="simple"/>
            </div>

            <div class="pt-3">
           <x-cms-form-input type="password" name="password" label="Password" value="{{ old('password','') }}"  wrapper="simple"/>
        </div>

        <div class="pt-3">
           <x-cms-form-input type="password" name="password_confirmation" label="Confirm password" value="{{ old('password_confirmation','') }}"  wrapper="simple"/>
              
        </div>
           
            <div class="text-center p-4">
                <x-cms-form-button name="reset" label="Reset Password" value="" wrapper="none" class="button btn-primary btn"/>
            </div>

            <input type="hidden" name="token" value="{{request()->route('token')}}" />
   

            @if (session('status'))
               <div class="mb-4 font-medium text-sm text-green-600">
                   {!! session('status') !!}
               </div>
            @endif
            
            </form>

    </div>
       


{{-- 
    <div class="flex flex-center flex-align-center" style="height: 80vh; flex-direction: column">

<H1 class="text-center w-100">Reset Your Password</H1>



  <div class="" style="display: flex; justify-content: center; width: 100%;">   
      
    <div class="formpanel">
     <form action="/reset-password" method="POST">
         @csrf
         
         <x-cms-form-input type="text" name="email" label="Email" value="{{ old('email', request()->email ) }}" wrapper="simple"/>

        <x-cms-form-input type="password" name="password" label="Password" value="{{ old('password','') }}"  wrapper="simple"/>
        <x-cms-form-input type="password" name="password_confirmation" label="Confirm password" value="{{ old('password_confirmation','') }}"  wrapper="simple"/>
           
        <input type="hidden" name="token" value="{{request()->route('token')}}" />

         <x-cms-form-button name="reset" label="Reset Password" value="" wrapper="simple"/>
         
         @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {!! session('status') !!}
            </div>
         @endif
         
         </form>

    </div>

</div>

    </div> --}}


@endsection