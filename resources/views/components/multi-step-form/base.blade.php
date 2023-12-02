
<form class="multistepform" method="{{ $method }}" action="{{ $action }}" @if($id) id="{{ $id }}" @endif>

    @csrf

    <ol class="step-display">
        @stack($progress)
    </ol>

    {{ $slot }}

    @isset($completed)
        <div class="msf-completed">
        {{ $completed }}
        </div>
    @endif



</form>

{{-- 
@once
    @push('styles')
        @style('/vendor/ascent/cms/form/multistepform/ascent-multistepform.css')
    @endpush

    @push('scripts')
        @script('/vendor/ascent/cms/form/multistepform/ascent-multistepform.js')
    @endpush
@endonce --}}
