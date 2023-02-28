

<div class="flex" style="flex: 0 0 200px">
    <H2 class="text-muted text-center" style="width: 100%;">EMBEDDED CODE</H2>
</div>

<div class="m-2">
    
</div>

<div class="container p-3">
    <x-forms-fields-code label="Code" name="{{ $name }}[code]" :value="$value->code ?? ''" wrapper="none" description="Paste in third party code - please note, it will be rendered directly to the viewable page. Only paste code which you trust."/>
</div>
