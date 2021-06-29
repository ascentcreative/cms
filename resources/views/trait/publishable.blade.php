@php

 
@endphp

{{-- <strong>PUBLISHING</strong> --}}

<div class="border p-2 ml-5" style="flex-basis: 300px;">
    
    <div class="p-2">
    {{-- <div class="col-4"> --}}
        <x-cms-form-checkbox type="" name="publishable" label="Published?" checkedValue="1" uncheckedValue="0" value="{{ old('publishable', $model->publishable) }}" wrapper="inline"></x-cms-form-checkbox>
    {{-- </div> --}}
    </div>

    <div class="p-2">
    {{-- <div class="col-4"> --}} 
        <x-cms-form-datetime name="publish_start" label="Publish At" :value="old('publish_start', $model->publish_start)" wrapper="inline">
            (leave blank to publish immediately)
        </x-cms-form-input>
    {{-- </div> --}}
    </div>


    <div class="p-2">
    {{-- <div class="col-4"> --}}
        <x-cms-form-datetime name="publish_end" label="Published Until" :value="old('publish_end', $model->publish_end)" wrapper="inline">
            (leave blank to publish indefinitely)
        </x-cms-form-datetime>
    {{-- </div> --}}
    </div>

</div>

