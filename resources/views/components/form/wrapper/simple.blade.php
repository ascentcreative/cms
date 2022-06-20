<div class="simple-form-element element-wrapper {{$class}}" id="{{$name}}-wrapper">

    @hasSection('label')
        <label for="@yield('name')" class="simple-form-element-label">@yield('label')</label>
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

@if(isset($charlimit)) 
    @once
        @push('scripts')
            @script('/vendor/ascent/cms/form/components/charlimit/ascent.jquery.charlimit.js')
        @endpush
        @push('styles')
            @style('/vendor/ascent/cms/form/components/charlimit/ascent.jquery.charlimit.css')
        @endpush
    @endonce

    @push('scripts')
        <script>

            $(document).ready(function() {
                $('[name={{ $name }}]').charlimit({
                    'max': '{{ $charlimit }}',
                    'force': true
                });
            });

        </script>
    @endpush
@endif


