@extends(config('cms.wrapper_blade')) 

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
  </script>
@endpush

@section('contenthead')
    <H1>Contact Us</H1>
@endsection

@section('contentmain')
  

<form action="{{ action('AscentCreative\CMS\Controllers\ContactController@submit') }}" id="demo-form">

    @csrf
    
    <x-cms-form-input type="text" label="Your name" name="name" value="{{old('name', '')}}" wrapper="simple"/>

    <x-cms-form-input type="text" label="Your Email Address" name="email" value="{{old('email', '')}}" wrapper="simple"/>

    <x-cms-form-textarea label="Your Message" name="message" value="{{ old('message', '') }}" wrapper="simple" />

    {{-- <x-cms-form-button label="Send Message" name="submit" value="submit" wrapper="simple"/> --}}
    
    <button class="g-recaptcha" 
        data-sitekey="{{ config('cms.recaptcha_sitekey') }}" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button>

</form>


@endsection
