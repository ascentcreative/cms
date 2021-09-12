<x-cms-form-blockselect columns="1" name="cfilter[{{ $name }}]" xmaxSelect="1" :options="$opts" wrapper="simple" label="" :value="request()->cfilter[$name] ?? []"/>





    {{-- <button class="filter-submit">Go</button> --}}
    
