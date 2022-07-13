<div class="simple-form-element element-wrapper {{$class}}" id="{{$name}}-wrapper">

    @hasSection('label')
        <label for="@yield('name')" class="simple-form-element-label d-flex justify-content-between">
            @yield('label')
            @if($attributes['helpkey'])
                <x-help-link :key="$attributes['helpkey']" title="{{ $attributes['helptitle'] ?? $label }}" />
            @endif
        </label>
    @endif

    @yield('element')
    
    
    @if($errors->first(dotName($name)))
    {{-- @if($errors->first($name)) --}}
        <small class="validation-error alert alert-danger form-text" role="alert">
            {!! $errors->first(dotName($name)) !!}
            {{-- {!! $errors->first($name) !!} --}}
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