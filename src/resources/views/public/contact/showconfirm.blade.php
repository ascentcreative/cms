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
    <H1>Thank you for your message</H1>
@endsection

@section('contentmain')
  
    @includeFirst(['contact.confirm', 'cms::public.contact.confirm'])

@endsection
