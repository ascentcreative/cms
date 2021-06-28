<div class="inline-form-element element-wrapper {{$class}} flex flex-between" id="{{$name}}-wrapper">

    @hasSection('label')
        <label for="@yield('name')" class="inline-form-element-label">@yield('label')</label>
    @endif

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
        <div class="error-display"></div>
</div> 