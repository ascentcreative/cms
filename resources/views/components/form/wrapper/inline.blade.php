<div class="inline-form-element inline-wrapper flex-align-center element-wrapper {{$class}} flex" id="{{$name}}-wrapper">

    @hasSection('label')
        <label for="@yield('name')" class="inline-form-element-label mr-3">
            @yield('label')
            @if($attributes['helpkey'])
                <x-help-link :key="$attributes['helpkey']" title="@yield('label')"/>
            @endif
        </label>
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
        <div class="error-display" for="{{ $name }}"></div>
</div> 

@include('cms::components.form.support.charlimit')