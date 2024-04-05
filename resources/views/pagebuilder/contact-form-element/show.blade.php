@extends('pagebuilder::components.element.show')

@section('content')

@if(session()->get('enquiry_received') == 1)
    <div class="alert alert-success">
        Thank you for your message - we'll get back to you as soon as possible.
    </div>
@endif

<form action="{{ action('AscentCreative\CMS\Controllers\ContactController@submit') }}" id="demo-form">

    @csrf
    
    <div class="pb-3">
        <x-cms-form-input type="text" label="Your name" name="name" value="{{old('name', '')}}" wrapper="simple"/>
    </div>

    <div class="pb-3">
        <x-cms-form-input type="text" label="Your Email Address" name="email" value="{{old('email', '')}}" wrapper="simple"/>
    </div>

    <div class="pb-3">
        <x-cms-form-textarea label="Your Message" name="message" value="{{ old('message', '') }}" wrapper="simple" rows="10"/>
    </div>
    {{-- <x-cms-form-button label="Send Message" name="submit" value="submit" wrapper="simple"/> --}}
    
    <div class="text-right">
    <button class="btn button btn-primary g-recaptcha" 
        data-sitekey="{{ config('cms.recaptcha_sitekey') }}" 
        data-callback='onSubmit' 
        data-action='submit'>Send Message</button>
    </div>

</form>

@overwrite


@push('scripts')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
  </script>
@endpush