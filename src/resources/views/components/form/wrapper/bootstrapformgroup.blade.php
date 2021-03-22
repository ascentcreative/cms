<div class="form-group row element-wrapper" id="{{$name}}-wrapper">
    <label for="@yield('name')" class="col-2 col-form-label">@yield('label'):</label>
    <div class="col">
        @yield('element')
        <small class="form-text text-muted">
            {{ $slot }}
        </small>
        @if($errors->first($name))
            <small class="validation-error alert alert-danger form-text" role="alert">
                {{ $errors->first($name) }}
            </small>
        @endif
    </div>
</div> 