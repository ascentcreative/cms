{{-- <x-cms-form-blockselect columns="1" name="cfilter[{{ $name }}]" xmaxSelect="1" :options="$opts" wrapper="simple" label="" :value="request()->cfilter[$name] ?? []"/> --}}

    <div class="flex flex-column">
        <x-cms-form-options type="checkboxes" name="cfilter[{{ $name }}]" wrapper="none" label="" :value="request()->cfilter[$name] ?? []" :options="$opts" />
    </div>

    {{-- <button class="filter-submit">Go</button> --}}
    
