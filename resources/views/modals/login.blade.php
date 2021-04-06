@extends('cms::modal')

{{-- @php
    $modalSize = 'modal-lg';
    
@endphp --}}

@section('modalContent')

    @includeFirst(['auth.loginform', 'cms::auth.loginform'], ['intended'=>request()->intended])

@endsection

@push('scripts')
<SCRIPT>
    $('A#btn-register').addClass('modal-link').attr('href', '/modal/cms::modals.register?intended=' + $('#form_login input[name="intended"]').val());
</SCRIPT>
@endpush