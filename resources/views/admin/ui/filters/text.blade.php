<div class="flex flex-column text-left">
    <x-cms-form-input type="text" name="cfilter[{{ $name }}]" wrapper="simple" label="" :value="request()->cfilter[$name] ?? ''" />
</div>