@aware(['idx'=>-1])

@push(\view()->shared('progress'))
    <li class="{{ $icon }}" id="progress-{{ Str::slug($label) }}">
        {{-- <A href="#" wire:click="$set('current_step', '{{ $id }}')"> --}} {{ $label }} {{-- </a> --}}
    </li>
@endpush



<div class="msf-step" id="msf-step-{{ Str::slug($label) }}" data-stepslug="{{ Str::slug($label) }}" data-validators="{{
    Crypt::encryptString(json_encode(['validators'=>$validators, 'messages'=>$validatormessages]));        
}}">

  

    {{ $slot }}

    <div class="msf-nav">

        <div class="m-5 text-right">

            {{-- Don't show this button on the first tab  --}}
            {{-- @if($idxStep != 0) --}}
                <button class="btn btn-secondary prevBtn pull-right msf-back {{ $backIcon }}" 
                type="button"> {{ $backLabel }}</button>
            {{-- @endif --}}

            <button class="btn btn-primary nextBtn pull-right msf-continue {{ $continueIcon }}" 
            type="button"> {{ $continueLabel }}</button>

            {{-- Maybe the last step should have a different label? --}}

        </div>

    </div>

</div>