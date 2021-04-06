    
    @yield('element')
    
    @if($errors->first($name))
        <small class="validation-error alert alert-danger form-text" role="alert">
            {!! $errors->first($name) !!}
        </small>
        @else

            @if(trim($slot))
                <small class="form-text text-muted">
                    {{ $slot }}
                </small>
            @endif

        @endif
